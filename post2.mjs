import { createServer } from "https";
import { readFileSync } from "fs";
import fetch from "node-fetch";
console.log("it works");
const SERVER = "https://c2.pondersource.net/as4";
const body = readFileSync("./experiments/as4-testbed/testMsg.xml");

const reqOut = await fetch(SERVER, {
	method: "POST",
	body,
	headers: {
		'Content-Type': 'multipart/related; boundary="------=_Part_39_869791064.1665565057596";    type="application/soap+xml"; charset=UTF-8',
	}
});
const resBody = await reqOut.text();

for(const header of reqOut.headers){
	console.log("RESP HEADER", `Name: ${header[0]}, Value:${header[1]}`);
}
console.log("RESP", resBody);
