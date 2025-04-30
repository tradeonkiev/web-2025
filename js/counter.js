function uniqueElements(arr) {
    let result = {};
    if (Array.isArray(arr)){
        for (let elem of arr){
            elem = String(elem);
            if (result[elem]){
                result[elem]++;
            } else {
                result[elem] = 1;
            }
        }
    } else {
        result[arr] = 1;
    }
    console.log(result);
}

uniqueElements([1, 2, 3, 1, '1']);
uniqueElements(1);
uniqueElements([true, false, null, 'false']);
