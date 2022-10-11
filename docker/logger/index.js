import { createServer } from "https";
import { readFileSync } from "fs";
console.log("it works");
const server = https.createServer({
	key: readFileSync("/tls/privkey.pem"),
	cert: readFileSync("/tls/fullchain.pem")
}, (req, res) => {
	res.end("hello");
});
server.listen(443);
