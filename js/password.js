function generatePassword(length) {
    function shuffle(obj){
        const answer = []
        for (const elem of obj){
            answer.push([elem, Math.random()]);
        }
        answer.sort((x, y) => x[1] - y[1])
        return answer.map(x => x[0])
    }
    const lowercase = 'abcdefghijklmnopqrstuvwxyz';
    const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const numbers = '0123456789';
    const specials = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    const allChars = lowercase + uppercase + numbers + specials;
  
    const guaranteed = [
      lowercase[Math.floor(Math.random() * lowercase.length)],
      uppercase[Math.floor(Math.random() * uppercase.length)],
      numbers[Math.floor(Math.random() * numbers.length)],
      specials[Math.floor(Math.random() * specials.length)]
    ];
  
    const remaining = []
    for (let i = 0; i < length - 4; i++){
        remaining.push(allChars[Math.floor(Math.random() * allChars.length)])
    }
  
    const passwordChars = shuffle([...guaranteed, ...remaining]);
    return passwordChars.join('');
  }
  
  console.log(generatePassword(8)); 
  console.log(generatePassword(12));
  console.log(generatePassword(16));