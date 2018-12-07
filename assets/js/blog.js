function sendMessage() {
    $.ajax({
        type: 'POST',
        url: 'send-message',
        data: {
            text: $('#reply-text').val(),
            user_email: $('#user_email').val()
        },
    });
}