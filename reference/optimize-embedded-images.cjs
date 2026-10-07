const fs=require('fs');
const sharp=require('C:/Users/See/AppData/Local/Programs/Open Design/resources/app/node_modules/sharp');
async function main(){
const file='felosi-home-before-about-v2.html';let html=fs.readFileSync(file,'utf8');
const sources=[...new Set([...html.matchAll(/data-asset-source="([^"]+)"/g)].map(m=>m[1]))];
const assets=new Map();
for(const source of sources){
  let buffer,mime,width,height;
  if(source.endsWith('.svg')){buffer=fs.readFileSync(source);mime='image/svg+xml';({width,height}=await sharp(buffer).metadata())}
  else{const result=await sharp(source).resize({width:960,height:960,fit:'inside',withoutEnlargement:true}).webp({quality:76,alphaQuality:100,effort:5}).toBuffer({resolveWithObject:true});buffer=result.data;({width,height}=result.info);mime='image/webp'}
  assets.set(source,{data:`data:${mime};base64,${buffer.toString('base64')}`,width,height});
}
html=html.replace(/<img\b[^>]*>/g,tag=>{
  const source=tag.match(/data-asset-source="([^"]+)"/)?.[1];if(!source)return tag;
  const a=assets.get(source);return tag.replace(/\ssrc="[^"]*"/,` data-src="${source}" src="${a.data}"`).replace(/\bwidth="[^"]*"/,`width="${a.width}"`).replace(/\bheight="[^"]*"/,`height="${a.height}"`);
});
html=html.replace("setZoom(false);zoomImage.src=resolvedSource;","setZoom(false);zoomImage.src=resolvedSource;\n  loadOriginalImage(source,zoomImage);");
html=html.replace("document.getElementById('preview-image').replaceChildren(image);openDialog(preview)","document.getElementById('preview-image').replaceChildren(image);loadOriginalImage(source,image);openDialog(preview)");
const helper=`
// Always display the embedded preview first; upgrade only after the local original loads.
function loadOriginalImage(source,target){
  const requested=source.getAttribute('data-src');if(!requested)return;
  const token=String(Number(target.dataset.loadVersion||0)+1);target.dataset.loadVersion=token;
  const fullImage=new Image();
  fullImage.onload=()=>{if(target.dataset.loadVersion===token)target.src=fullImage.src};
  fullImage.onerror=()=>{};
  fullImage.src=new URL(requested,source.baseURI).href;
}
`;
html=html.replace("function showGalleryImage(index){",helper+"\nfunction showGalleryImage(index){");
if(Buffer.byteLength(html)>1800000)throw Error('Embedded document exceeds compact preview budget: '+Buffer.byteLength(html));
fs.writeFileSync(file,html,'utf8');console.log(JSON.stringify({htmlBytes:Buffer.byteLength(html),images:sources.length,embeddedPreviewMaxEdge:960,fullResolutionOriginalsPreserved:true}));
}
main().catch(e=>{console.error(e);process.exitCode=1});
