import { createServer } from "https";
import { readFileSync } from "fs";
console.log("it works");
const SERVER = "http://server/index.php/apps/peppolnext/api/v1";

const server = createServer({
	key: readFileSync("/tls/privkey.pem"),
	cert: readFileSync("/tls/fullchain.pem")
}, (reqIn, resIn) => {
	let body = "";
	console.log(reqIn.method, reqIn.url);
	reqIn.on('data', (chunk) => {
		console.log('CHUNK', chunk.toString());
		body += chunk.toString();
	});
	
	reqIn.on('end', async (chunk) => {
		console.log('END');;
		const reqOut = await fetch(SERVER, {
			method: "POST",
			body
		});
    const resBody = await reqOut.text();
		console.log("RESP", resBody);
		resIn.end(resBody);
	});
});
server.listen(443);
