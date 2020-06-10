var tipoAsesoria = 
{
    "familiar" : "Familiar",
    "academico" : "Académico",
    "emocional" : "Emocional",
    "relaciones" : "Relaciones Interpersonales",
    "sexualidad" : "Sexualidad"
};

var motivoAsesoria = 
{
    familiar: 
    [
        "Separación o divorcio de padres",
        "Falta de comunicación",
        "Falta de atención, cuidado",
        "Maltrato, violencia familiar",
        "Pelea con hermanos",
        "Peleas entre padres",
        "Conflicto con papás",
        "Ausencia de padres (física, emocional)",
        "Desintegración familiar",
        "Adicción de un integrante  de la familia",
        "Actividades delictivas al interior de la familia",
        "Integrante víctima de un delito (secuestro, homicidio. Abuso o violación)",
        "Problemas económicos/alimenticios",
        "Falta de un espacio privado en hogar (hacinamiento)",
        "Rol familiar que no corresponde con la edad",
        "Padres sobreprotectores",
        "Hipersexualidad en la familia",
        "Enfermedad física o mental en algún familiar",
        "Dinámica familiar (interacción, relaciones)"
    ],
    academico: 
    [
       "Derivado por docentes",
       "Problemas de conducta",
       "Rendimiento escolar",
       "Proyecto de vida",
       "Deserción escolar",
       "Desinterés por el estudio",
       "Problemas en la relación alumno-docente",
       "Sobreexigencia académica",
       "Problemas de aprendizaje" 
    ],
    emocional:
    [
        "Problemas de autoestima",
        "Duelos",
        "Somatizaciones",
        "Trastornos alimenticios",
        "Estrés",
        "Ansiedad",
        "Falta de identificación de emociones",
        "Conflicto de indentidad adolescente",
        "Depresión",
        "Tristeza",
        "Sospecha de trastorno de personalidad o psicótico",
        "Crisis emocionales",
        "Autolesiones",
        "Consumo de sustancias",
        "Ideación suicida/riesgo suicida",
        "Intento suicida",
        "Falla en el control de impulsos"
    ],
    relaciones: 
    [
        "Problemas en el noviazgo",
        "Problemas con amigos",
        "Dificultades de adaptación",
        "Aislamiento",
        "Peleas a golpes dentro y/o fuera de la escuela",
        "Violencia: noviazgo, entre iguales",
        "Barrios, pandillas (grupos de pertenencia)",
        "Acoso escolar"    
    ],
    sexualidad:
    [
        "Embarazo",
        "Abuso sexual",
        "Acoso sexual",
        "Orientación general sobre sexualidad",
        "Vida sexual activa",
        "Hipersexualidad",
        "Dudas acerca del inicio de vida sexual activa",
        "Identidad sexual"
    ]
}

var tipo = document.getElementById("tipoAsesoria");
var motivo = document.getElementById("motivoAsesoria");
addOptions(motivoAsesoria["familiar"]);


tipo.onchange = function(actualizar) {
    var llaveSeleccionada = tipo.options[tipo.selectedIndex].value;
    var motivosPorLlave = motivoAsesoria[llaveSeleccionada];
    removeOptions();
    addOptions(motivosPorLlave);

}
var llaves = Object.keys(tipoAsesoria);

for(var i=0; i<llaves.length ; i++){
    tipo.options.add(new Option(tipoAsesoria[llaves[i]],llaves[i]));
}


function addOptions(motivos){
    for(var i=0; i<motivos.length; i++){
        motivo.options.add(new Option(motivos[i], motivos[i]));
    }
}

function removeOptions(){

    var i;
    for(i = motivo.options.length - 1 ; i >= 0 ; i--){
        motivo.remove(i);
    }
}





