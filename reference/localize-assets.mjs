import fs from 'node:fs/promises';
import path from 'node:path';
await fs.mkdir('assets',{recursive:true});
const manifest=[];
for(const file of await fs.readdir('reference')){
 if(!file.endsWith('.txt'))continue;
 const code=await fs.readFile(path.join('reference',file),'utf8');
 const prefix=code.match(/const assetPathPrefix = "([^"]+)"/)?.[1];
 if(!prefix)continue;
 for(const m of code.matchAll(/const (\w+) = `\$\{assetPathPrefix\}\/([^`]+)`/g)){
  const local=`assets/${file.replace('.txt','')}-${m[1]}.${m[2].split('.').pop()}`;
  manifest.push({section:file.replace('.txt',''),variable:m[1],source:`${prefix}/${m[2]}`,local});
 }
}
const results=await Promise.allSettled(manifest.map(async a=>{const r=await fetch(a.source);if(!r.ok)throw Error(`${a.local}: ${r.status}`); const b=Buffer.from(await r.arrayBuffer()); await fs.writeFile(a.local,b);a.bytes=b.length;if(a.local.endsWith('.svg')){const root=b.toString('utf8').match(/<svg\b[^>]*>/)?.[0];a.width=root?.match(/width="([^"]+)"/)?.[1];a.height=root?.match(/height="([^"]+)"/)?.[1];a.viewBox=root?.match(/viewBox="([^"]+)"/)?.[1];}else if(b.toString('ascii',1,4)==='PNG'){a.width=b.readUInt32BE(16);a.height=b.readUInt32BE(20);}}));
await fs.writeFile('reference/asset-manifest.json',JSON.stringify(manifest,null,2));
console.log(JSON.stringify({assets:manifest.map(({source,...a})=>a),failures:results.filter(x=>x.status==='rejected').map(x=>String(x.reason))},null,2));
