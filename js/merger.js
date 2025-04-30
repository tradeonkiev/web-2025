function mergeObjects(obj1, obj2){
    let obj = obj1;
    for (let key in obj2){
        obj[key] = obj2[key];
    }
    console.log(obj);
}
mergeObjects({ a: 1, b: 2 }, { b: 3, c: 4 })
console.log({...{ a: 1, b: 2 }, ...{ b: 3, c: 4 }})