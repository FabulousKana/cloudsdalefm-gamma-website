console.group("CloudsdaleFM.net Player")
const URLS = {
    //STREAM: "http://188.116.8.133/cloudsdale" <- nono to no ssl ~ Kana
    STREAM: "https://server.cloudsdalefm.net/cloudsdale",
    STATUS: "https://server.cloudsdalefm.net/status-json.xsl"
}
//transform: translateX(-5%) skewx(50deg);
const stream = new Audio(URLS.STREAM)
stream.preload = "none"

function mapSliderValue(mouseX, dom) {
    return mouseX / dom.clientWidth
}

function createElement(html) {
    let wrapper = document.createElement("div")
    wrapper.innerHTML = html
    return wrapper.children[0]
}

const svg = {
    PLAY: createElement(`<svg class="CDFM button pointer" viewBox="0 0 200 200"><polygon points="190,100 10,10 10,190" style="fill:#567997;" /></svg>`),
    LOADING: createElement(`<svg class="CDFM button" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="#567997" /></svg>`),
    STOP: createElement(`<div>STOP</div>`),
    ERROR: createElement(`<div>ERROR</div>`)
}

console.log("Creating Player")
const virtualDom = document.createElement("div") // i know it's not virtual dom but stfu
virtualDom.innerHTML = `
 <div class="CDFM buttonBG centered"></div>
    <div class="CDFM rightSide">
    <div class="CDFM title centered">
        <span>Some - title</span>
    </div>
    <div class="CDFM slider centered">
        <div class="CDFM sliderInner centered">
            <img src="player/images/speaker.png" class="CDFM speaker"></img>
            <div class="CDFM sliderOuter">
                <div class="CDFM sliderValue"></div>
            </div>
        </div>
    </div>
</div>` // Yes rly

virtualDom.get = function(className) {
    return this.getElementsByClassName(className)[0]
}
const button = virtualDom.get("buttonBG")
const slider = virtualDom.get("sliderValue")
const sliderOuter = virtualDom.get("sliderOuter")

function addMode(name) {
    return node => {
        node[name] = function() {
            this.innerHTML = ""
            this.appendChild(svg[name.toUpperCase()])
        }
    }
}
addMode("loading")(button)
addMode("play")(button)
addMode("stop")(button)
addMode("error")(button)

button.play()

function playStream() {
    button.loading()
    button.disabled = true
    stream.load()
    stream.play()
    .then(() => {
        button.stop()
        button.disabled = false
    })
    .catch(err => {
        button.error()
        button.disabled = false
    })
}

function pauseStream() {
    stream.pause()
    button.play()
}

function setVolume(vol) {
    if(vol > 100) vol = 100
    else if(vol < 0) vol = 0
    slider.style = `transform: translateX(-${100-(vol)}%) skewx(50deg);`
    stream.volume = vol/100
}

sliderOuter.addEventListener("mousemove", e => {
    if(e.buttons !== 1) return;
    let vol = mapSliderValue(e.offsetX, sliderOuter)
    setVolume(vol*100)
})

button.addEventListener("mousedown", e => {
    if(button.disabled) return;
    if(stream.paused) playStream()
    else pauseStream()
})

window.addEventListener("DOMContentLoaded", () => {
    const app = document.getElementById("player")
    if(!app) console.error("DIV element with id \"player\" not found")
    console.log("Rendering Player")
    Array.from(virtualDom.childNodes).forEach(node => {
        app.appendChild(node)
    })
    // idk why xD
})