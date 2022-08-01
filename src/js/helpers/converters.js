export const convertToInt = (n) => {
	if (!isNaN(parseFloat(n)) && parseFloat(n) % 1 === 0 && n.match(/^[0-9]+$/i) && isFinite(n))
		return parseFloat(n);
	
	throw 'Error in converting to integer.'; 
}


export const convertToFloat = (n) => {
	if (!isNaN(parseFloat(n)) && n.match(/^[+-]?\d+(\.\d+)?$/) && isFinite(n))
		return parseFloat(n);
	
	throw 'Error in converting to float.'; 
}