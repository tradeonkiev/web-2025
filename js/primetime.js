function isPrimeNumber(input) {
    if (typeof input !== 'number' && !Array.isArray(input)) {
      console.error(input + ' - не является числом или массивом чисел');
      return;
    }
  
    if (typeof input == 'number') {
      if (input % 1) {
        console.error(input + ' - число должно быть целым');
        return;
      }
      console.log(input + (isPrime(input) ? ' простое число' : ' не простое число'));
      return;
    }
  
    let primes = [];
    let notPrimes = [];
    input.forEach(num => {
      if (typeof num !== 'number' || !Number.isInteger(num)) {
        console.error(num + ' - неверный формат ввода');
        return;
      }
  
      if (isPrime(num)) {
        primes.push(num);
      } else {
        notPrimes.push(num);
      }
    })
  
    // for (let num of input) {
      
    // }
  
    let result = '';
    if (primes.length > 0) {
      result += primes.join(', ') + ' простые числа';
    }
    if (notPrimes.length > 0) {
      if (result) result += ', ';
      result += notPrimes.join(', ') + ' не простые числа';
    }
  
    console.log(result);
  }

function isPrime(num) {
    if (num <= 1 || num % 2 == 0) return false;
    if (num === 2) return true;

    for (let i = 3; i <= Math.sqrt(num); i += 2) {
        if (num % i === 0) return false;
    }

    return true;
}


isPrimeNumber(3);
isPrimeNumber(4);             
isPrimeNumber([3, 4, 4]);      
isPrimeNumber('test');         
isPrimeNumber([3, 'test']);   
isPrimeNumber(4.5);           
isPrimeNumber([3.5, 4, 5]); 