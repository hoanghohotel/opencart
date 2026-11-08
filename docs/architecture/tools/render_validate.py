"""Render shared-geometry SVG pages with Chromium; validate mxGraph structure and PNG outputs."""
from pathlib import Path
import json,xml.etree.ElementTree as ET
from playwright.sync_api import sync_playwright
from PIL import Image
ROOT=Path(__file__).resolve().parents[3]; OUT=ROOT/'docs/architecture'
manifest=json.loads((OUT/'evidence/diagram-manifest.json').read_text())
checks=[]
for f,pages in manifest.items():
 root=ET.parse(OUT/(f+'.drawio')).getroot(); diagrams=root.findall('diagram'); assert len(diagrams)==len(pages)
 for page in diagrams:
  cells=page.findall('./mxGraphModel/root/mxCell'); ids=[c.attrib['id'] for c in cells]; assert len(ids)==len(set(ids))
  for c in cells:
   if c.get('edge')=='1':assert c.get('source') in ids and c.get('target') in ids
   if c.get('vertex')=='1':
    g=c.find('mxGeometry');assert g is not None and float(g.get('width'))>0 and float(g.get('height'))>0
 checks.append({'file':f+'.drawio','pages':len(pages),'xml':'PASS','references':'PASS'})
with sync_playwright() as pw:
 browser=pw.chromium.launch(executable_path='/usr/bin/chromium',headless=True,args=['--no-sandbox'])
 page=browser.new_page(device_scale_factor=1)
 for file,pages in manifest.items():
  for i,meta in enumerate(pages):
   suffix='' if i==0 else f'-page-{i+1:02d}'
   svg=OUT/'exports'/f'{file}{suffix}.svg';png=svg.with_suffix('.png')
   page.set_viewport_size({'width':meta['width'],'height':meta['height']})
   page.set_content('<html><head><style>html,body{margin:0;padding:0;}</style></head><body>'+svg.read_text()+'</body></html>');page.screenshot(path=str(png))
   with Image.open(png) as im:
    assert im.size==(meta['width'],meta['height'])
    assert im.getextrema()[0][0] < im.getextrema()[0][1],png
 browser.close()
report={'drawio_files':checks,'pages_rendered':sum(map(len,manifest.values())),'png':'PASS: dimensions, decode, nonblank','renderer':'SVG geometry → Chromium, not official draw.io/plugin export','editor_roundtrip':'NOT VERIFIED: draw.io plugin unavailable'}
(OUT/'evidence/validation.json').write_text(json.dumps(report,ensure_ascii=False,indent=2));print(json.dumps(report,ensure_ascii=False,indent=2))
# Contact sheets for visual inspection, preserving full-size originals.
for file,pages in manifest.items():
 thumbs=[]
 for i in range(len(pages)):
  suffix='' if i==0 else f'-page-{i+1:02d}'
  with Image.open(OUT/'exports'/f'{file}{suffix}.png') as im:
   im.thumbnail((350,500)); thumb=Image.new('RGB',(370,530),'white');thumb.paste(im,(10,10));thumbs.append(thumb)
 sheet=Image.new('RGB',(370*min(4,len(thumbs)),530*((len(thumbs)+3)//4)),(226,232,240))
 for i,t in enumerate(thumbs):sheet.paste(t,((i%4)*370,(i//4)*530))
 sheet.save(OUT/'exports'/f'{file}-contact-sheet.png')
