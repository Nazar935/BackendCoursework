class Message {
    static element = document.getElementById("message");
    static neutral = "neutral";
    static negative = "negative";
    static positive = "positive";
    static open = false;
    static typesArray = [Message.negative, Message.positive, Message.neutral];

    static longTimeout = null;

    static show(text, type) {
        let timeout = 0;
        if (this.open) {
            this.close();
            timeout = 300;
        }

        setTimeout(() => {
            Message.open = true;

            this.typesArray.forEach(messageType => {
                if (type === messageType)
                    Message.element.classList.add(messageType);
                else
                    Message.element.classList.remove(messageType);
            });

            Message.element.querySelector(".text").innerHTML = text;

            this.longTimeout = setTimeout(() => {
                this.close();
            }, 10000);
        }, timeout);
    }

    static close() {
        clearTimeout(this.longTimeout);
        this.typesArray.forEach(type => Message.element.classList.remove(type));
        setTimeout(() => {
            Message.open = false;
        })
    }
}

Message.element.querySelector("button").addEventListener("click", function () {
    Message.close();
});


//<?= isset($message)? "\nMessage.show('" . $message['text'] . "', Message." . $message['type'] . ");" : "\n" ?>