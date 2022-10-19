import { createServer } from "https";
import { readFileSync } from "fs";
console.log("it works");
const SERVER = "https://nc1.docker/index.php/apps/peppolnext/api/v1/testbed";

const server = createServer({
	key: readFileSync("/tls/privkey.pem"),
	cert: readFileSync("/tls/fullchain.pem")
}, (reqIn, resIn) => {
	const buffers = [];
	console.log(reqIn.method, reqIn.url);
	reqIn.on('data', (chunk) => {
		console.log('CHUNK', chunk.toString());
		buffers.push(chunk);
	});
	
	reqIn.on('end', async (chunk) => {
		console.log('END');
		const body = Buffer.concat(buffers);
		// for (let i = 0; i < body.length; i++) {
		// 	console.log(i, body[i], String.fromCharCode(body[i]));
		// }
		const reqOut = await fetch(SERVER, {
			method: "POST",
			body,
			headers: reqIn.headers
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