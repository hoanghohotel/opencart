from pathlib import Path
import csv,hashlib,json,re,xml.etree.ElementTree as ET
from PIL import Image
R=Path(__file__).resolve().parents[3];O=R/'docs/architecture';E=O/'evidence'
original=list(csv.DictReader((E/'files.csv').open()))
for r in original:assert hashlib.sha256((R/r['path']).read_bytes()).hexdigest()==r['sha256'],r['path']
trace=list(csv.DictReader((E/'diagram-trace.csv').open()))
for r in trace:
 p,line=r['source'].rsplit(':',1); assert (R/p).is_file() and 1<=int(line)<=len((R/p).read_text(errors='replace').splitlines())
manifest=json.loads((E/'diagram-manifest.json').read_text());pages=0
for name,ps in manifest.items():
 tree=ET.parse(O/(name+'.drawio')); assert len(tree.findall('diagram'))==len(ps)
 for i,p in enumerate(ps):
  suffix='' if i==0 else f'-page-{i+1:02d}'
  assert (O/'mermaid'/f'{name}{suffix}.mmd').is_file()
  for extension in ['svg','png']:assert (O/'exports'/f'{name}{suffix}.{extension}').is_file()
  with Image.open(O/'exports'/f'{name}{suffix}.png') as im:im.verify()
  pages+=1
schema=json.loads((E/'schema.json').read_text());assert len(schema)==59
represented={}
root=ET.parse(O/'07-database-er.drawio')
for cell in root.findall('.//mxCell'):
 value=cell.get('value','')
 for t in schema:
  if value.startswith(t['name']+'\n'):represented[t['name']]=True
assert len(represented)==59
# Check relative documentation links (anchors not evaluated as GitHub line anchors are renderer-specific).
links=0
for p in O.glob('*.md'):
 for target in re.findall(r'\]\(([^)]+)\)',p.read_text()):
  if target.startswith(('http:','https:','#')):continue
  assert (p.parent/target.split('#')[0]).exists(),(str(p),target)
  links+=1
out={'original_source_hashes':len(original),'source_unchanged':'PASS','diagram_files':len(manifest),'pages':pages,'source_references':len(trace),'source_reference_paths_and_lines':'PASS','schema_tables_represented':len(represented),'local_document_links':links,'png_decode':'PASS','drawio_editor_roundtrip':'NOT VERIFIED: plugin/tool unavailable','runtime_business_paths':'NOT RUN: source analysis task, no writes to app/database'}
(E/'verification.json').write_text(json.dumps(out,ensure_ascii=False,indent=2));print(json.dumps(out,ensure_ascii=False,indent=2))
