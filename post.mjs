import fetch from 'node-fetch';
import { readFileSync } from "fs";
fetch('https://c2.pondersource.net/as4', {
  method: 'POST',
  headers: {
    'Content-Type': 'multipart/related; boundary="------=_Part_39_869791064.1665565057596";    type="application/soap+xml"; charset=UTF-8',
  },
  body: readFileSync('./experiments/as4-testbed/testMsg.xml')
});
// curl -d'@./experiments/as4-testbed/testMsg.xml' -H "Content-Type: multipart/related; boundary=\"------=_Part_39_869791064.1665565057596\";    type=\"application/soap+xml\"; charset=UTF-8" https://c2.pondersource.net/as4

