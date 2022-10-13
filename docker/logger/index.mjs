import { createServer } from "https";
import { readFileSync } from "fs";
console.log("it works");
const SERVER = "https://nc1.docker/index.php/apps/peppolnext/api/v1/testbed";

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
	
	const headersIn = {};
	for(const header of reqIn.headers){
		console.log("REQ HEADER", `Name: ${header[0]}, Value:${header[1]}`);
		headersIn[header[0]] = header[1];
	}

	reqIn.on('end', async (chunk) => {
		console.log('END');;
		const reqOut = await fetch(SERVER, {
			method: "POST",
			body
		});
		const resBody = await reqOut.text();

		for(const header of reqOut.headers){
			console.log("RESP HEADER", `Name: ${header[0]}, Value:${header[1]}`);
			resIn.setHeader(header[0], header[1]);
		}
		console.log("RESP", resBody);
		resIn.end(resBody);
	});
});
server.listen(443);