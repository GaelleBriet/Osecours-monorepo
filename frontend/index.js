import express from 'express';
import serveStatic from 'serve-static';
import path from 'path';
import cors from 'cors';

//initialise the express package
const app = express();

app.use(cors());

//use the serve-static package to serve the bundled app files in the dist directory
app.use('/', serveStatic(path.join(process.cwd(), '/dist')));

// this * route is to serve project on different page routes except root `/`
app.get(/.*/, function (req, res) {
    res.sendFile(path.join(process.cwd(), '/dist/index.html'));
});

//heroku automatically assigns port so leave it to do it's
//work, don't set a port in the heroku dashboard. while the
//5000 or whatever number you set will be for your local
//machine.
const port = process.env.PORT || 5000;
app.listen(port);
console.log(`app is listening on port: ${port}`);