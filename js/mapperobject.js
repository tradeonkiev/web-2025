function mapObject(obj, callback) {
    const result = {};
    for (const key in obj) {
        result[key] = callback(obj[key]);
    }
    
    return result;
  }
  
  const nums = { a: 1, b: 2, c: 3 };
  console.log(mapObject(nums, x => x * 2));
  nums.a = '1';
  console.log(mapObject(nums, x => x * 2));