(function() {
const FPS = 25

function randomChar(){
    const pool = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"
    return pool.charAt(Math.floor(Math.random()*pool.length))
}

function setCharAt(str,index,chr) {
    if(index > str.length-1) return str;
    return str.substr(0,index) + chr + str.substr(index+1);
}

function addShuffleTo(node) {
    const reg = (/\{([^\}]+)\}/).exec(node.innerText)
    const END = reg[1]
    const START = node.innerText.replace(reg[0], "")
    node.shuffleData = {
        animating: false,
        START,
        END
    }    
    node.innerText = node.shuffleData.START

    node.startShuffle = function() {
        this.shuffleData.animating = true
        this.innerText = this.shuffleData.END
        this.shuffle(0)
    }

    node.stopShuffle = function() {
        this.shuffleData.animating = false
    }

    node.resetText = function() {
        this.innerText = this.shuffleData.START
    }

    node.shuffle = function(startIndex) {
        const { animating, END } = this.shuffleData
        if(!animating) return null;
        if(startIndex > END.length) return null;
    
        let str = this.innerText
    
        for(let i = 0; i<END.length;i++) {
            if(i < startIndex) {
                str = setCharAt(str,i,END[i]);
            } else {
                str = setCharAt(str,i,randomChar())
            }
        }
        this.innerText = str
        setTimeout(() => this.shuffle(++startIndex), 1000/FPS)
    }

    node.addEventListener("mouseenter", () => {
        node.startShuffle()
    })

    node.addEventListener("mouseleave", () => {
        node.stopShuffle()
        node.resetText()
    })
}
window.addEventListener("DOMContentLoaded", () => {
    let nodes = document.getElementsByClassName("shuffleOnHover")
    for(const node of nodes) {
        addShuffleTo(node)
    }
})

})()