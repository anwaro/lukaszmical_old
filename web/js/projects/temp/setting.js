


var SET = SET || {};

SET={boltz : 5.67e-8,
	sun : 1374/4,
	wAlbedo : 0.3,
	tauIR : 0.3,
	tauVis: 0.5,
	nemStratum : 1,
	stratumVal : [{ir:0.2,vis:0.8} , {ir:0.2,vis:0.8} , {ir:0.2,vis:0.8} , {ir:0.2,vis:0.8} , {ir:0.2,vis:0.8}],
	all_IR:0.5,
	IR:	[ {przech:0.5, odbi:0.5, albedo:0.5} , {przech:0.5, odbi:0.5, albedo:0.5} , {przech:0.5, odbi:0.5, albedo:0.5} , {przech:0.5, odbi:0.5, albedo:0.5} , {przech:0.5, odbi:0.5, albedo:0.5}],
	all_Vis:0.5,
	Vis:	[ {przech:0.5, odbi:0.5, albedo:0.5} , {przech:0.5, odbi:0.5, albedo:0.5} , {przech:0.5, odbi:0.5, albedo:0.5} , {przech:0.5, odbi:0.5, albedo:0.5} , {przech:0.5, odbi:0.5, albedo:0.5}],
	x:300,
	y:300,
	ran : new Array(),
	temp:10
};


SET.nam =[
	"/images/projects/temp/crops.png",	// 0
	"/images/projects/temp/desert.png",	// 1
	"/images/projects/temp/forest.png",	// 2
	"/images/projects/temp/ice.png",		// 3
	"/images/projects/temp/meadow.png",	// 4
	"/images/projects/temp/snow.png",		// 5
	"/images/projects/temp/soil.png",		// 6
	"/images/projects/temp/sun.png",		// 7
	"/images/projects/temp/water.png"		// 8
];

SET.img=[];
	
for(i in SET.nam){
	var img = new Image();
	img.src = SET.nam[i];
	
	SET.img.push(img);

}

SET.ground = 6;

for(var k =0;k<3e4;k++){
	SET.ran.push(Math.random());
}

/**
*
*	Ustawia wartosc na wybrany typ podloza
*
**/

SET.checkAlbedo1=function(){
	if( document.getElementById('albedo1').checked) {
		SET.wAlbedo=parseFloat($("select#albedo_select option:selected").val());
		SET.ground=parseInt($("select#albedo_select option:selected").data("gr"))
	}
};

/**
*
*	Ustawia vartosc albedo 
*
**/

SET.checkAlbedo2=function(){
	if( document.getElementById('albedo2').checked){
		SET.wAlbedo = parseFloat($("input#albedo_val").val());
		$("#albedo_val_view").text(SET.wAlbedo);
		SET.ground=6;
	}
};

/**
*
*	Ustawia ilosc warstw atmosfery 
*
**/

SET.changeNemberOfStratum=function(){
	SET.nemStratum = parseFloat($("input#atmo").val());
	$("#atmo_val").text(SET.nemStratum);
	SET.addInputRangeStratum();
	SET.changeValueIrAndVis();
	for(i in SET.stratumVal){
		SET.stratumVal[i].ir = 0.2;
		SET.stratumVal[i].vis = 0.8;
	}
};

/**
*
*	Zmienia wartosc stalej slonecznej
*
**/

SET.changeSunConst= function(){
	SET.sun = parseInt($("input#sun_const").val())/4;
	$("#sun_const_val").text(parseInt($("input#sun_const").val()));

};

/**
*
*	Dodaje lub kasuje inputy związane z alebedo kazdej warstwy 
*
**/

SET.addInputRangeStratum=function(){
	var myDiv = document.getElementById("eachStratum"),
		table = document.createElement("table"),
		tbody = document.createElement("tbody");
		
	
	for(var i =0;i<SET.nemStratum;i++){
		
		// tytuł
		var row = document.createElement("tr");					//new row
		var cell = document.createElement("td");				//new cell
		var cellText = document.createTextNode((i+1)+" WARSTWA"); //create text
		cell.setAttribute('colSpan','3');						// add atribute 
		cell.appendChild(cellText);
		cell.style.textAlign = "center";
		row.appendChild(cell);
		tbody.appendChild(row);
		
		// pierwszy inpuut 
		
		 row = document.createElement("tr");
		////////////////////////////////////////////////////////////////
		  cell = document.createElement("td"); 		
		   cellText = document.createTextNode('IR');
		   cell.appendChild(cellText);
		 row.appendChild(cell);
		/////////////////////////////////////////////////////////////////
		  cell = document.createElement("td");
		
		  var inp = document.createElement("input");
		   inp.setAttribute("type","range");
		   inp.setAttribute("min","0");
		   inp.setAttribute("max","1");
		   inp.setAttribute("step","0.01");
		   inp.setAttribute("value","0.2");
		   inp.setAttribute("data-tau","IR");
		   inp.setAttribute("data-index",i);
		   inp.setAttribute("id","t_IR_"+i);
		
		  cell.appendChild(inp);
		 row.appendChild(cell);
		///////////////////////////////////////////////////////////////
		  cell = document.createElement("td"); 		
		   cellText = document.createTextNode('0.2');
		   cell.setAttribute('id','tau_IR_val_'+i);
		  cell.appendChild(cellText);
		 row.appendChild(cell);
		tbody.appendChild(row);
		
		// drugi inpuut 
		
		 row = document.createElement("tr");
		  cell = document.createElement("td"); 		
		   cellText = document.createTextNode('Vis');
		   cell.appendChild(cellText);
		 row.appendChild(cell);
		/////////////////////////////////////////////////////////////
		  cell = document.createElement("td");
		   inp = document.createElement("input");
		   inp.setAttribute("type","range");
		   inp.setAttribute("min","0");
		   inp.setAttribute("max","1");
		   inp.setAttribute("step","0.01");
		   inp.setAttribute("value","0.8");
		   inp.setAttribute("data-tau","Vis");
		   inp.setAttribute("data-index",i);
		   inp.setAttribute("id","t_Vis_"+i);
		
		  cell.appendChild(inp);
		 row.appendChild(cell);
		/////////////////////////////////////////////////////////////
		  cell = document.createElement("td"); 		
		   cellText = document.createTextNode('0.8');
		   cell.setAttribute('id','tau_Vis_val_'+i);
		  cell.appendChild(cellText);
		 row.appendChild(cell);
		tbody.appendChild(row);
	
	}
	table.appendChild(tbody);
	myDiv.innerHTML = "";
	myDiv.appendChild(table);

};

/**
*
*	Ustawia pochłanianie krodko i dlugofalowe poszczegolnych warstw atmosfery
*
**/

SET.changeValueIrAndVis=function(){
	$("#eachStratum :input").each(function(){
		var ele = $("#"+$(this).attr('id'));
		
		ele.change(function(){
			if($(ele).data("tau")=="IR"){
				SET.stratumVal[parseInt($(ele).data("index"))].ir=ele.val();
				$('#tau_IR_val_'+$(ele).data("index")).text(ele.val());
			}
			else{
				SET.stratumVal[parseInt($(ele).data("index"))].vis=ele.val();
				$('#tau_Vis_val_'+$(ele).data("index")).text(ele.val());
			}
		});
	});
}


