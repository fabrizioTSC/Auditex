function DistinctArray(array,valor){
    let distinct = [...new Set(array.map(x => x[valor]))];
    return distinct;
    // console.log("PROVEEDORES",proveedores);
}


function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
      r: parseInt(result[1], 16),
      g: parseInt(result[2], 16),
      b: parseInt(result[3], 16)
    } : null;
}

// GENERAL FILTER ARRAY
const distinct = (value,index,self) => {
  return self.indexOf(value) == index;
}

window.chartColors = {
  red: 'rgb(255, 99, 132)',
  reddark: 'rgb(255, 50, 60)',
  orange: 'rgb(255, 159, 64)',
  yellow: 'rgb(255, 205, 86)',
  green: 'rgb(80, 200, 2)',
  blue: 'rgb(54, 162, 235)',
  purple: 'rgb(153, 102, 255)',
  grey: 'rgb(201, 203, 207)',
  black: 'rgb(50, 50, 50)',
  mostaza: 'rgb(195, 170, 5)',
  reddarkdark: 'rgb(140, 10, 20)'
};