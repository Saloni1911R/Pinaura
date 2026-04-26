document.addEventListener("DOMContentLoaded", () => {

const cat = document.querySelector(".cat-helper img");
const bubble = document.querySelector(".cat-bubble");

if (!cat || !bubble) return;

const tips = [
"Stay inspired, meow~ 🌸",
"Upload your latest creation 🎨",
"Click ❤️ if you love it!",
"Paws up! Time to explore 🐾",
"Take a coffee break ☕ then pin again!",
"You’re doing amazing 💖",
"Art + Heart = Pinaura 💕",
"Discover something beautiful today ✨",
"Keep creating magic 🌈"
];

let lastIndex = -1;

// Random tip without repeating same one
function getRandomTip() {
let index;

do {
index = Math.floor(Math.random() * tips.length);
} while (index === lastIndex);

lastIndex = index;
return tips[index];
}

// Show tip with fade effect
function showRandomTip() {
bubble.style.opacity = "0";

setTimeout(() => {
bubble.textContent = getRandomTip();
bubble.style.opacity = "1";
}, 250);
}

// First tip immediately
showRandomTip();

// Change every 5 sec
setInterval(showRandomTip, 5000);

// Hover Animation
cat.addEventListener("mouseenter", () => {
cat.style.transform = "scale(1.1) rotate(-3deg)";
cat.style.filter = "drop-shadow(0 0 20px rgba(255,255,255,0.9))";
cat.style.transition = "all 0.3s ease";
});

cat.addEventListener("mouseleave", () => {
cat.style.transform = "scale(1) rotate(0deg)";
cat.style.filter = "drop-shadow(0 0 10px rgba(255,255,255,0.7))";
});

// Click Animation
cat.addEventListener("click", () => {
showRandomTip();

cat.style.transform = "scale(0.95)";

setTimeout(() => {
cat.style.transform = "scale(1)";
}, 150);
});

});