'use strict'; //이 문구는 ES5부터 적용되는 키워드로, 안전한 코딩을 위한 하나의 가이드라인
              //정의되지 않은 변수사용, 변수나 객체의 삭제, 함수 파라미터에 중복된 이름 등 올바르지 않은 문법을 사전에 검출한다.

var socket = io.connect('https://www.rockyoumuch.tk:3000');

/* 
 * emit - 서버는 클라이언트에게로, 클라이언트는 서버에게로 데이터를 보낸다
 * on - 서버는 클라이언트에게로, 클라이언트는 서버에게로 데이터를 받는다
 */

socket.on('connect', function() {
   //var name = prompt('대화명을 입력하시오.', '');
    var name = user;
    socket.emit('newUserConnect', name); //저장한 name 값을 newUserConnect 이벤트를 호출하면서 파라미터로 전달한다.
});

var chatWindow = document.getElementById('chatWindow'); //사용자간의 채팅 텍스트를 노출하는 영역


socket.on('updateMessage', function(data) {
    if (data.name === 'SERVER') {
        var info = document.getElementById('info');
        info.innerHTML = data.message;

        setTimeout(() => {
            info.innerText = '';
        }, 1000);

    } else {
        var chatMessageEl = drawChatMessage(data);
        chatWindow.appendChild(chatMessageEl);

        chatWindow.scrollTop = chatWindow.scrollHeight; // chatWindow의 스크롤을 chatWindow의 스크롤 높이만큼 내려주는 부분
    }
});

function drawChatMessage(data) {
    var wrap = document.createElement('p');
    var message = document.createElement('span');
    var name = document.createElement('span');

    name.innerText = data.name;
    message.innerText = data.message;

    name.classList.add('output__user__name');
    message.classList.add('output__user__message');

    wrap.classList.add('output__user');
    wrap.dataset.id = socket.id;

    wrap.appendChild(name);
    wrap.appendChild(message);

    return wrap;
}

var sendButton = document.getElementById('chatMessageSendBtn'); //사용자가 채팅 텍스트를 작성 후 전송할 버튼
var chatInput = document.getElementById('chatInput'); //사용자가 채팅 텍스트를 작성할 input

// sendButton.addEventListener('click', function() {
//     var message = chatInput.value;
//     if (!message) return false;
//     socket.emit('sendMessage', {
//         message
//     });
//     chatInput.value = '';
// });

sendButton.addEventListener('keypress', function(e) {
    if(e.key === 'Enter') {
    var message = chatInput.value;
    if (!message) return false;
    socket.emit('sendMessage', {
        message
    });
    chatInput.value = '';
    }
});