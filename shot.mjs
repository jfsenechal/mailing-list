import { chromium } from 'playwright';
const url = 'http://127.0.0.1:8123/';
const sizes = [['desktop',1280,900],['tablet',820,1100],['mobile',390,900]];
const browser = await chromium.launch();
for (const [name,w,h] of sizes) {
  const page = await browser.newPage({ viewport:{width:w,height:h}, deviceScaleFactor:2 });
  await page.goto(url, { waitUntil:'networkidle' });
  await page.waitForTimeout(700);
  await page.screenshot({ path:`/tmp/home-${name}.png`, fullPage:true });
  console.log('shot', name);
}
await browser.close();
