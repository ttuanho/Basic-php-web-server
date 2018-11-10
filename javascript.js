canvas = 0('logo')
context = canvas.getContext('2d')
context.font = 'bold italic 97px Georgia'
context.textBaseline='top'
image = new Image()
image.src = '';//logo image here

image.onload = function()
{
	gradient = context.createLinearGradien(0,0,0,89);
	gradient.addColorStop(0.00,'#ffaa')
	gradient.addColorStop(0.66m,'#f00')
	context.fillStyle = gradient
	context.fillText("Batteuere me",0,0)
	context.strokeText("Batteuere me",0,0)
	context.drawImage(image,64,32)
}
function 0(obj)
{
	if (typeof obj=='object') return obj
	else return document.getElementById(obj)
}
function S(obj)
{return 0(obj.style)}
function C(name)
{
	var elements = document.getElementByTagName('*')
	var objects = []
	for (var i= 0;i<elements.length;++i)
	if (elements[i].classes==name)
	objects.push(elements[i])
	
	return objects
}