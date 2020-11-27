const express = require('express');
const http = require('http');
const axios = require('axios'); //Promise 기반의 HTTP Client로 사이트의 HTML을 가져올 때 사용할 라이브러리
const cheerio = require('cheerio'); //Axios의 결과로 받은 데이터에서 필요한 데이터를 추출하는데 사용하는 라이브러리
const app = express();
const server = http.createServer(app);
const fs = require('fs');
const io = require('socket.io')(server);
const cron = require("node-cron");
const log = console.log;

let crawlingData; // 크롤링한 결과를 담을 변수

app.use(express.static('src'));

app.get('/', function(req, res) {
    fs.readFile('./index.php', (err, data) => {
        if (err) throw err;

        res.writeHead(200, {
                'Content-Type': 'text/html'
            })
            .write(data)
            .end();
    });
});

// 채팅 서버 기능
// 1. 접속 처리
io.sockets.on('connection', function(socket) {
    socket.on('newUserConnect', function(name) {
        socket.name = name;

        var message = name + '님이 접속했습니다.';

        io.sockets.emit('updateMessage', { //io.sockets : 나를 포함한 전체 소켓
            name: 'SERVER',
            message: message
        });
    });
// 2. 접속 종료 처리
    socket.on('disconnect', function() {
        var message = socket.name + '님이 퇴장했습니다';
        socket.broadcast.emit('updateMessage', { //socket.broadcast : 나를 제외한 전체 소켓
            name: 'SERVER',
            message: message
        });
    });

    socket.on('sendMessage', function(data) {
        data.name = socket.name;
        io.sockets.emit('updateMessage', data);
    });

});



//크롤링 기능 -> 크롤링할 사이트 : 핫트랙스 신규 음반 페이지
const getHtml = async () => {
    try {
        return await axios.get("http://www.hottracks.co.kr/ht/biz/record/recordCategoryMain?ctgrId=00030202", ); // axios.get 함수를 이용하여 비동기로 html 파일을 가져온다. 
    } catch (error) {
        console.error(error);
    }
};


getHtml()
    .then(html => {
        let ulList = [];
        const $ = cheerio.load(html.data);
        const $bodyList = $("div.pd_list ul").children("li");

        //추출할 목록 : 앨범 제목, 밴드이름, url, 이미지url 
        $bodyList.each(function(i, elem) {
            ulList[i] = {
                title: $(this).find('a div.cont p.brand').text(), //앨범 제목
                band: $(this).find('a div.cont p.tit').text(), //밴드 이름
                url: $(this).find('a').attr('href'),
                img_url: $(this).find('a div.thum img').attr('src'),
                img_alt: $(this).find('a div.thum img').attr('alt'),
                /*
                title: $(this).find('strong.news-tl a').text(),
                 url: $(this).find('strong.news-tl a').attr('href'),
                image_url: $(this).find('p.poto a img').attr('src'),
                 image_alt: $(this).find('p.poto a img').attr('alt'),
                 summary: $(this).find('p.lead').text().slice(0, -11),
                 date: $(this).find('span.p-time').text()
                */

            };
        });

        crawlingData = ulList.filter(n => n.title);
        fs.writeFileSync('../crawling/data.json', JSON.stringify(crawlingData));
        return crawlingData;
    })
    .then(res => log(res));

app.all("/data.json", function(request, response) {
    // 셋 중에 한 가지 방법을 사용하면 됨
    // response.writeHead(200,{'Content-Type':'text/html'});
    // response.end(data, 'utf-8'); // 브라우저로 전송
    // 방법1
    response.type("application/json");
    response.send(JSON.stringify(crawlingData));

    // // 방법2
    // response.type("text/json");
    // response.send(data);

    // // 방법3
    // response.send(data);
});

async function handleAsync() {
    const getH = await getHtml()
        .then(html => {
            let ulList = [];
            const $ = cheerio.load(html.data);
            const $bodyList = $("div.pd_list ul").children("li");

            $bodyList.each(function(i, elem) {
                ulList[i] = {
                    title: $(this).find('a div.cont p.brand').text(), //앨범 제목
                    band: $(this).find('a div.cont p.tit').text(), //밴드 이름
                    url: $(this).find('a').attr('href'), 
                    img_url: $(this).find('a div.thum img').attr('src'),
                    img_alt: $(this).find('a div.thum img').attr('alt'),
                    /*
                    title: $(this).find('strong.news-tl a').text(),
                     url: $(this).find('strong.news-tl a').attr('href'),
                    image_url: $(this).find('p.poto a img').attr('src'),
                     image_alt: $(this).find('p.poto a img').attr('alt'),
                     summary: $(this).find('p.lead').text().slice(0, -11),
                     date: $(this).find('span.p-time').text()
                    */

                };
            });

            crawlingData = ulList.filter(n => n.title);
            fs.writeFileSync('../crawling/data.json', JSON.stringify(crawlingData));
            return crawlingData;
        })
        .then(res => log(res));
}

//30분마다 한번씩 주기적으로 실행할 수 있도록 스케줄링 해준다.
cron.schedule("*/30 * * * *", async () => {
    console.log("running a task every two minutes");
    await handleAsync();
});


server.listen(3000, function() {
    console.log('서버 실행중');
});