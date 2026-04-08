import './bootstrap';
import { Picker } from 'emoji-mart'

const pickerOptions = { 
    onEmojiSelect: (emoji) => {
        const input = document.getElementById('chat-input');
        input.value += emoji.native; // Insere o emoji no campo de texto
    } 
}
const picker = new Picker(pickerOptions)
document.getElementById('emoji-picker-container').appendChild(picker)

