/*
* Lukasz Mical
* lukaszmical.pl
*
* Mala biblioteka zawierajaca podstawowe 
* funkcje potrzebne do manipulawania objektami DOM
* oraz ustawiania plikow cookie, wukonuwania zapytan do serwera
*/
function _myQuery(selector){ 
	/* 
	* ustalamy element objektu 
	* jezeli przekazujemy objekt przypisujemy go bezposrednio
	* przeszukujemy dokument gdy przekazujemy nazwe 
	* gdy otzrzymujemy element objety w "<>" tworzymy nowy objekt tego typu
	* w innym przypadku tworzumy element "DIV"
	*/
	
	if(typeof selector ==="object"){
		this.el = selector;
	}
	else if(selector.match(/^<[a-z]+>$/i)){
		this.el = document.createElement(selector.replace(/<|>/g, ''));
	}
	else if(document.querySelector(selector)){
		this.el =document.querySelector(selector);
	}	
	else{
		this.el = document.createElement("div");
	}
	
	//sprawdzamy czy nie jest elementem posiada
	// atrybut height lub width
 		 
 	this.isSpecial = this.el.hasAttribute("height") || this.el.hasAttribute("width"); 
	
	// funkcja ustalajaca style elementu przyjmuje objekt z 
	// wlasciwosciami lub wlaciwosc i jej wartosc
	this.el.css=function(property, value){
		if(typeof property === "string"){
			if(value){
				this.style[property] = value;
			}
			else{
				return getComputedStyle(this)[property];
			}
		}
		else if(typeof property === "object"){
			for(var prop in property){
				this.style[prop] = property[prop];
			}
		}
		return this;	
	}
	
	
	// uakaznanie elementu
	this.el.show=function(){
		this.style.display = "block";
		return this;
	}
	
	//sprawdzenie czy element jest ukryty
	this.el.isHidden=function(){
		return (window.getComputedStyle(this).display === 'none');
	}
	
	// ukrycie elementu
	this.el.hide=function(){
		this.style.display = "none";
		return this;
	}	
	
	// powolne ukazanie elemntu z  mozliwoscia wykonania funkcji po zakonczeniu
	this.el.fadeIn=function(time,callback){
		time = time || 500;
		
		this.style.opacity=0;
		this.style.display = "block";
		
		var element = this,
			step=(1/time)*20;
		for(var i=0,o=0;i<time;i+=20){
			(function(time,element,opacity){
				setTimeout(function() {element.style.opacity=opacity;},time);
			})(i,this,o);
			o+=step;
		}
		setTimeout(function(){
				element.style.opacity = 1;
				callback&&callback();
		},time);
		return this;
	}
	
	
	// powolne ukrycie elemntu z  mozliwoscia wykonania funkcji po zakonczeniu
	this.el.fadeOut=function(time,callback){
		time = time || 500;
		
		this.style.opacity=1;
		
		var element = this,
			step=(1/time)*20;
		
		for(var i=0,o=1;i<time;i+=20){
			(function(time,element,opacity){
				setTimeout(function() {element.style.opacity=opacity;},time);
			})(i,this,o);
			o-=step;
		}
		setTimeout(function(){
			element.style.display = "none";
			element.style.opacity=1;
			callback&&callback();
		},time);
		return this;		
	}
	
	//dodanie calsy do elementu
	this.el.addClass=function(className){
		this.classList.add(className);
		return this;
	}
	
	//usuniecie klasy z elementu
	this.el.removeClass=function(className){
		this.classList.remove(className);
		return this;
	}
	
	//sprawdzenie czy element zawiera dana klase
	this.el.hasClass=function(className){
		return this.classList.contains(className);
	}
	
	
	// ustawienie tekstu elementu 
	this.el.setText=function(text){
		if(text){
			this.textContent = text;
			return this;
		}
		else{
			return this.textContent;
		}
	}	
	
	// wyczyszczenie elementu 
	this.el.empty=function(){
		this.textContent = "";
		return this;
	}
	
	if(!this.isSpecial){
		// ustawienie wysokosci
		this.el.height=function(size){
			if(typeof size =="undefined"){
				return this.offsetHeight;
			}
			if(size.toString().match(/px|pt|pc|cm|mm|in|%|em|en|ex/i)){
				this.style.height = size;
			}
			else{
				this.style.height = size+"px";
			}		
			return this;
		}
		
		// ustawienie szerokosci elementu 
		this.el.width=function(size){
			if(typeof size =="undefined"){
				return this.offsetWidth;
			}
			if(size.toString().match(/px|pt|pc|cm|mm|in|%|em|en|ex/i)){
				this.style.width = size;
			}
			else{
				this.style.width = size+"px";
			}		
			return this;
		}
	}
	
	// ustawia lub zwraca wartosc atrybutu data o danym kluczu
	this.el.data = function(key, value){
		if(typeof value !="undefined"){
			this.setAttribute(key, value);
			return this;
		}
		else{
			return this.getAttribute(key);
		}
	}
	
	
	// usuwa atrybut data o danym kluczu 
	this.el.removeData=function(key){		
		this.removeAttribute(key);
		return this;
	}
	
	// zwucenie nowego objektu _myQuery dla rodzica
	this.el.parent = function(){
		return new _myQuery(this.parentNode);
	}
	
	this.el.addEvent=function(event,func){
		myQuery.addEvent(this, event, func);
		return this;
	}
	return this.el;	
 }
 
 
function myQuery(selector){
	return new _myQuery(selector);
}

$$ = myQuery;
 
 /*
 * Funkcja ustawiajaca pliki cookie
 * jaki argument moze przyjmowac trzy argumenty
 * jezeli podamy wszystkie trzy ustawiamy plik cookie 
 * z danym kluczem i wartoscia na okrac dni podanym jako argument
 * baez podania trzeciego argumentu ustawiamy ciasteczko bez terminu
 * wygasniecia; W przypadku podania jednego argumentu 
 * funkcja zwraca wrtosc ciasteczka o kluczu przekazanym w argumencie
 */
myQuery.cookie=function(key,value,expires){
	if(arguments.length > 1){
		var expiresCookie =''
		if(expires && typeof expires === "number"){
			var d = new Date();
			d.setTime(d.getTime() + (expires*24*60*60*1000));
			expiresCookie = "; expires="+d.toUTCString();
		}
		document.cookie = key + "=" + value + expiresCookie;
	}
	else if(arguments.length == 1){
		var cookieArray = ("; " +document.cookie).split("; " + key + "=");
		if (cookieArray.length == 2){
			return  cookieArray.pop().split(";").shift();
		}
		else{
			return undefined;
		}
	}
}

// usuwa dany plik cookie
myQuery.deleteCookie=function(key){
	document.cookie = key + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

// zwraca kopie dowolnego objektu 
myQuery.clone=function(object){
	return JSON.parse(JSON.stringify(object));
}

// wywoluje funkcje przekazana jako argument
// po zaladowaniu strony
myQuery.load=function(action){
	document.addEventListener('DOMContentLoaded', action);
}

// wywoluje dana funkcje po okreslonym czasie
myQuery.delay=function(callback,time){
	if(typeof callback ==="function"){
		setTimeout(callback, time||1000);
	}
}

//funkcjia dodająca zdarzenie
myQuery.addEvent=function(element, event, func){
	if (element.addEventListener){
		element.addEventListener(event,func,false);
	}
	else if (element.attachEvent){
		element.attachEvent("on"+event, func);
	}
	else{
		element[event] = func;
	}
}
