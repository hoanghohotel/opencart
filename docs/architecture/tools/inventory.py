"""Static inventory: literal references only; never treats regex matches as runtime proof."""
from pathlib import Path
import csv, json, re, hashlib, subprocess
ROOT=Path(__file__).resolve().parents[3]
OUT=ROOT/'docs/architecture/evidence'
def write(name, rows, fields):
 with (OUT/name).open('w') as f:
  w=csv.DictWriter(f,fields); w.writeheader(); w.writerows(rows)
files=subprocess.check_output(['git','ls-files','-z'],cwd=ROOT).decode().split('\0')
inv=[]; methods=[]; loads=[]; calls=[]; tables=[]; records=[]
for rel in filter(None,files):
 if rel.startswith("docs/architecture/"): continue
 p=ROOT/rel; b=p.read_bytes(); inv.append(dict(path=rel,bytes=len(b),sha256=hashlib.sha256(b).hexdigest()))
 if p.suffix not in ['.php','.twig','.js','.sql','.json','.xml','.md','.txt','.ini'] and p.name!='.htaccess': continue
 s=b.decode('utf-8',errors='replace')
 if p.suffix!='.php': continue
 vendor='/vendor/' in rel
 ns=re.search(r'namespace\s+([^;{]+)',s)
 cls=re.search(r'\bclass\s+(\w+)(?:\s+extends\s+(\w+))?',s)
 fs=list(re.finditer(r'(?:(public|protected|private)\s+)?(?:static\s+)?function\s+(&?\w+)\s*\(',s))
 def at(pos): return s.count('\n',0,pos)+1
 def method(pos):
  prior=[m for m in fs if m.start()<=pos]
  return prior[-1].group(2) if prior else ''
 rec=dict(path=rel,namespace=ns.group(1) if ns else '',cls=cls.group(1) if cls else '',methods=[m.group(2) for m in fs],vendor=vendor)
 records.append(rec)
 for m in fs: methods.append(dict(path=rel,line=at(m.start()),namespace=rec['namespace'],cls=rec['cls'],method=m.group(2),visibility=m.group(1) or 'public',vendor=vendor))
 for m in re.finditer(r"\$this->load->(model|controller|view|language|library|helper|config)\(\s*(['\"])([^'\"]+)\2",s):
  kind,target=m.group(1),m.group(3)
  app=rel.split('/')[0]
  dest={'model':f'{app}/model/{target}.php','controller':f'{app}/controller/{target}.php','view':f'{app}/view/template/{target}.twig','language':f'{app}/language/en-gb/{target}.php','library':f'system/library/{target}.php','helper':f'system/helper/{target}.php','config':f'system/config/{target}.php'}[kind]
  loads.append(dict(path=rel,line=at(m.start()),method=method(m.start()),kind=kind,target=target,target_path=dest,exact_file_exists=(ROOT/dest).exists()))
 for m in re.finditer(r'\$this->model_(\w+)->(\w+)\(',s):
  calls.append(dict(path=rel,line=at(m.start()),method=method(m.start()),model_property=m.group(1),called_method=m.group(2)))
 # Normalize literal DB_PREFIX concatenation, then extract SQL table positions.
 normalized=re.sub(r'''["']\s*\.\s*DB_PREFIX\s*\.\s*["']''','oc_',s)
 for m in re.finditer(r'\b(FROM|JOIN|UPDATE|INTO|TABLE)\s+`?(oc_\w+)`?',normalized,re.I):
  tables.append(dict(path=rel,line=normalized.count('\n',0,m.start())+1,method=method(min(m.start(),len(s))),sql_token=m.group(1).upper(),table=m.group(2)))
write('files.csv',inv,['path','bytes','sha256'])
write('methods.csv',methods,['path','line','namespace','cls','method','visibility','vendor'])
write('literal-loads.csv',loads,['path','line','method','kind','target','target_path','exact_file_exists'])
write('model-calls.csv',calls,['path','line','method','model_property','called_method'])
# Get line/method from original line instead: replacement never adds/removes newlines.
for t in tables:
 s=(ROOT/t['path']).read_text(errors='replace'); pos=sum(len(l) for l in s.splitlines(True)[:t['line']-1]); fs=list(re.finditer(r'function\s+(\w+)\s*\(',s[:pos])); t['method']=fs[-1].group(1) if fs else ''
write('sql-table-access.csv',tables,['path','line','method','sql_token','table'])
sql=(ROOT/'install/opencart.sql').read_text(); schema=[]
for m in re.finditer(r'CREATE TABLE `(\w+)`\s*\((.*?)\) ENGINE=([^;]+);',sql,re.S):
 name,body,engine=m.groups(); cols=[]
 for line in body.splitlines():
  c=re.match(r'\s*`(\w+)`\s+(.*?)(?:,)?$',line)
  if c: cols.append(dict(name=c.group(1),definition=c.group(2).rstrip(',')))
 pk=re.search(r'PRIMARY KEY\s*\(([^)]+)\)',body)
 schema.append(dict(name=name,line=sql.count('\n',0,m.start())+1,columns=cols,pk=re.findall(r'`([^`]+)`',pk.group(1)) if pk else [],indexes=[dict(name=x.group(2),unique=bool(x.group(1)),columns=re.findall(r'`([^`]+)`',x.group(3))) for x in re.finditer(r'(UNIQUE )?KEY `(\w+)`\s*\(([^)]+)\)',body)],engine=engine,foreign_keys=re.findall(r'FOREIGN KEY[^\n]+',body)))
(OUT/'schema.json').write_text(json.dumps(schema,ensure_ascii=False,indent=2))
(OUT/'symbols.json').write_text(json.dumps(records,ensure_ascii=False,indent=2))
summary=dict(commit=subprocess.check_output(['git','rev-parse','HEAD'],cwd=ROOT).decode().strip(),files=len(inv),php_files=len(records),first_party_php=sum(not r['vendor'] for r in records),controllers=sum('/controller/' in r['path'] and not r['vendor'] for r in records),models=sum('/model/' in r['path'] and not r['vendor'] for r in records),tables=len(schema),foreign_keys=sum(len(t['foreign_keys']) for t in schema),literal_loads=len(loads),model_calls=len(calls),sql_table_references=len(tables))
(OUT/'summary.json').write_text(json.dumps(summary,indent=2)); print(json.dumps(summary,indent=2))
