function countVowels(input) {
    if (typeof input == 'string'){
        const vowels = 'аеёиоуыэюя';
        const found_vowels = [];
        let count = 0;
        for (let char of input) {
            if (vowels.includes(char)) {
                count += 1;
                found_vowels.push(char);
            }
        }
        console.log(count + ' (' + found_vowels.join(', ') + ')');
    }
    else {
        console.error(input + ' - не является строкой');
    }
}

countVowels('фцусвкмаеипнтрггтксучквмеи');
countVowels('121212');
countVowels('');
countVowels(new String(null));
countVowels(`${NaN}`)
countVowels(0)