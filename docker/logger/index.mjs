import { createServer } from "https";
import { readFileSync } from "fs";
console.log("it works");
const server = createServer({
	key: readFileSync("/tls/privkey.pem"),
	cert: readFileSync("/tls/fullchain.pem")
}, (req, res) => {
	console.log(req.method, req.url);
	req.on('data', (chunk) => {
		console.log('CHUNK', chunk.toString());
	});
	
	req.on('end', (chunk) => {
		console.log('END');;
	});
	
	res.end("hello");
});
server.listen(443);
