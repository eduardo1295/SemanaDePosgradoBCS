
var LandingPage = {
  html: null,
  css: null,
  components: '[{\"tagName\":\"div\",\"type\":\"text\",\"name\":\"\",\"removable\":true,\"draggable\":true,\"droppable\":false,\"badgable\":true,\"stylable\":true,\"stylable-require\":\"\",\"style-signature\":\"\",\"unstylable\":\"\",\"highlightable\":true,\"copyable\":true,\"resizable\":false,\"editable\":true,\"layerable\":true,\"selectable\":true,\"hoverable\":true,\"void\":false,\"state\":\"\",\"status\":\"hovered\",\"content\":\"Aquí se muestra el nombre del participante\",\"icon\":\"\",\"style\":\"\",\"classes\":[{\"name\":\"participante\",\"label\":\"participante\",\"type\":1,\"active\":true,\"private\":false,\"protected\":false}],\"script\":\"\",\"attributes\":{\"data-highlightable\":\"1\"},\"propagate\":\"\",\"dmode\":\"\",\"components\":[]},{\"tagName\":\"div\",\"type\":\"\",\"name\":\"Row\",\"removable\":true,\"draggable\":true,\"droppable\":\".gjs-cell\",\"badgable\":true,\"stylable\":true,\"stylable-require\":\"\",\"style-signature\":\"\",\"unstylable\":\"\",\"highlightable\":true,\"copyable\":true,\"resizable\":{\"tl\":0,\"tc\":0,\"tr\":0,\"cl\":0,\"cr\":0,\"bl\":0,\"br\":0,\"minDim\":1},\"editable\":false,\"layerable\":true,\"selectable\":true,\"hoverable\":true,\"void\":false,\"state\":\"\",\"status\":\"\",\"content\":\"\",\"icon\":\"\",\"style\":\"\",\"classes\":[{\"name\":\"gjs-row\",\"label\":\"gjs-row\",\"type\":1,\"active\":true,\"private\":1,\"protected\":false}],\"script\":\"\",\"attributes\":{},\"propagate\":\"\",\"dmode\":\"\",\"components\":[{\"tagName\":\"div\",\"type\":\"\",\"name\":\"Cell\",\"removable\":true,\"draggable\":\".gjs-row\",\"droppable\":true,\"badgable\":true,\"stylable\":true,\"stylable-require\":\"\",\"style-signature\":\"\",\"unstylable\":\"\",\"highlightable\":true,\"copyable\":true,\"resizable\":{\"tl\":0,\"tc\":0,\"tr\":0,\"cl\":0,\"cr\":1,\"bl\":0,\"br\":0,\"minDim\":1,\"bc\":0,\"currentUnit\":1,\"step\":0.2},\"editable\":false,\"layerable\":true,\"selectable\":true,\"hoverable\":true,\"void\":false,\"state\":\"\",\"status\":\"\",\"content\":\"\",\"icon\":\"\",\"style\":{},\"classes\":[{\"name\":\"gjs-cell\",\"label\":\"gjs-cell\",\"type\":1,\"active\":true,\"private\":1,\"protected\":false},{\"name\":\"c626\",\"label\":\"c626\",\"type\":1,\"active\":true,\"private\":false,\"protected\":false}],\"script\":\"\",\"attributes\":{},\"propagate\":\"\",\"dmode\":\"\",\"components\":[]},{\"tagName\":\"div\",\"type\":\"\",\"name\":\"Cell\",\"removable\":true,\"draggable\":\".gjs-row\",\"droppable\":true,\"badgable\":true,\"stylable\":true,\"stylable-require\":\"\",\"style-signature\":\"\",\"unstylable\":\"\",\"highlightable\":true,\"copyable\":true,\"resizable\":{\"tl\":0,\"tc\":0,\"tr\":0,\"cl\":0,\"cr\":1,\"bl\":0,\"br\":0,\"minDim\":1,\"bc\":0,\"currentUnit\":1,\"step\":0.2},\"editable\":false,\"layerable\":true,\"selectable\":true,\"hoverable\":true,\"void\":false,\"state\":\"\",\"status\":\"\",\"content\":\"\",\"icon\":\"\",\"style\":{},\"classes\":[{\"name\":\"gjs-cell\",\"label\":\"gjs-cell\",\"type\":1,\"active\":true,\"private\":1,\"protected\":false},{\"name\":\"c635\",\"label\":\"c635\",\"type\":1,\"active\":true,\"private\":false,\"protected\":false}],\"script\":\"\",\"attributes\":{},\"propagate\":\"\",\"dmode\":\"\",\"components\":[]},{\"tagName\":\"div\",\"type\":\"\",\"name\":\"Cell\",\"removable\":true,\"draggable\":\".gjs-row\",\"droppable\":true,\"badgable\":true,\"stylable\":true,\"stylable-require\":\"\",\"style-signature\":\"\",\"unstylable\":\"\",\"highlightable\":true,\"copyable\":true,\"resizable\":{\"tl\":0,\"tc\":0,\"tr\":0,\"cl\":0,\"cr\":1,\"bl\":0,\"br\":0,\"minDim\":1,\"bc\":0,\"currentUnit\":1,\"step\":0.2},\"editable\":false,\"layerable\":true,\"selectable\":true,\"hoverable\":true,\"void\":false,\"state\":\"\",\"status\":\"\",\"content\":\"\",\"icon\":\"\",\"style\":{},\"classes\":[{\"name\":\"gjs-cell\",\"label\":\"gjs-cell\",\"type\":1,\"active\":true,\"private\":1,\"protected\":false},{\"name\":\"c644\",\"label\":\"c644\",\"type\":1,\"active\":true,\"private\":false,\"protected\":false}],\"script\":\"\",\"attributes\":{},\"propagate\":\"\",\"dmode\":\"\",\"components\":[]}]}]',
  style: null,
};

var editor = grapesjs.init({
   // The `components` accepts HTML string or a JSON of components
  // Here, at first, we check and use components if are already defined, otherwise
  // the HTML string gonna be used
  //domComponents : LandingPage.components || LandingPage.html,
  // We might want to make the same check for styles
  //style: LandingPage.style || LandingPage.css,
  deviceManager: {
// options
},
assetManager: {
  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  upload: rutaImagenes,
  //dropzone: 1,
  //dropzoneContent: '<div class="dropzone-inner">Drop here your assets</div>',
  //uploadFile: false,
	//embedAsBase64: true,
    addBtnText: 'Agregar imagen',
    uploadText: 'Arrastre aquí los archivos o haga clic para subir',
    modalTitle: 'Seleccionar imágenes',
    inputPlaceholder: 'URL imagen'
    
},
plugins: [
  'gjs-blocks-basic',
  //'grapesjs-tooltip',
  //'grapesjs-touch'
],
pluginsOpts: {
  'gjs-blocks-basic': {
    blocks: ['column1', 'column2', 'column3','text',  'image' ],
    flexGrid: 0,
    stylePrefix: 'gjs-',
    addBasicStyle: true,
    category: 'Secciones',
    labelColumn1: '1 columna',
    labelColumn2: '2 columnas',
    labelColumn3: '3 columnas',
    labelColumn37: '2 Columns 3/7',
    labelText: 'Texto',
    labelImage: 'Imagen',
    
  }
},
  showOffsets: 1,
  noticeOnUnload: 0,
  container: '#gjs',
  height: '215.9mm',
  width:'329mm',
  fromElement: true,
  storageManager: {
    type: 0,
    autoload: false,
},
  styleManager : {
    sectors: [{
        id: 'Dimension',
      name: 'Tamaño',
      open: true,
      
      buildProps: ['width', 'height', 'margin', 'padding'],
      properties: [
        {id: 'height', type: 'integer', name: 'Alto', units: ['px'], defaults: '75px'},
        {id: 'width', type: 'integer', name: 'Ancho', units: ['px']},
        {
        property: 'margin', name: 'Margen exterior',
        properties:[
          { name: 'Superior', property: 'margin-top'},
          { name: 'Derecho', property: 'margin-right'},
          { name: 'Inferior', property: 'margin-bottom'},
          { name: 'Izquierdo', property: 'margin-left'}
        ],
      },{
        property  : 'padding', name: 'Margen interior',
        properties:[
          { name: 'Superior', property: 'padding-top'},
          { name: 'Derecho', property: 'padding-right'},
          { name: 'Inferior', property: 'padding-bottom'},
          { name: 'Izquierdo', property: 'padding-left'}
        ],
      }],
  }, {
    name: 'Fuente y alineación',
    open: false,
    buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'text-align', 'text-decoration'],
    properties:[
      { name: 'Familia', property: 'font-family',
      list: [
        //{ value : 'Thin',  name : 'Delgada'},
        { value : 'Arial',  name : 'Arial'},
        { value : 'Times New Roman, Times, serif',  name : 'Times New Roman'},
      ],},
      { 
        name: 'Tipo',
        property: 'font-weight',defaults: 'Normal',
        list: [
          //{ value : 'Thin',  name : 'Delgada'},
          { value : 'Normal',  name : 'Normal'},
          { value : 'Bold',  name : 'Negrita'},
        ],
      },
      { name: 'Tamaño', property: 'font-size',defaults: '20px',},
      { name: 'Espaciado de letras', property: 'letter-spacing'},
      { name:  'Color', property: 'color',defaults: 'rgb(0,0,0)'},
      {
        property: 'text-align',
        name: 'Alinear texto',
        type: 'radio',
        defaults: 'left',
        list: [
          { value : 'left',  name : 'Izquierda',    className: 'fa fa-align-left'},
          { value : 'center',  name : 'Centrado',  className: 'fa fa-align-center' },
          { value : 'right',   name : 'Derecha',   className: 'fa fa-align-right'},
          { value : 'justify', name : 'Justificado',   className: 'fa fa-align-justify'}
        ],
      },{
        property: 'text-decoration',
        name:'Decoración',
        type: 'radio',
        defaults: 'none',
        list: [
          { value: 'none', name: 'None', className: 'fa fa-times'},
          { value: 'underline', name: 'underline', className: 'fa fa-underline' },
          { value: 'line-through', name: 'Line-through', className: 'fa fa-strikethrough'}
        ],
      }],
  },
  /*{
    name: 'Decoración',
    open: false,
    buildProps: ['background-color', 'border-radius'],
    properties: [{
      name:'Color de fondo',
      property: 'background-color',
      defaults: '#fff',
    },{
      name:'Redondeado',
      property: 'border-radius',
      properties  : [
        { name: 'Arriba izquierda', property: 'border-top-left-radius'},
        { name: 'Arriba derecha', property: 'border-top-right-radius'},
        { name: 'Abajo derecha', property: 'border-bottom-left-radius'},
        { name: 'Abajo izquierda', property: 'border-bottom-right-radius'},
      ],
    },],
  }*/]
},
});



const bm = editor.BlockManager;
editor.on('load', () => {
        editor.getWrapper().addStyle({
          width: '100%',
          //height: '100%',
          border: 'none',
          padding: '20px'
        }),
        
        
        editor.BlockManager.getCategories().each(ctg => ctg.set('open', false))
});
var customBlock = {
    label: '<div>Nombre del participante</div>',
    attributes: {
        class: "gjs-fonts gjs-f-text"
    },
    content: "<div data-gjs-type='text' data-highlightable='1' class='participante' >Aquí se muestra el nombre del participante</div>",
    id: "myButtonId"
};

var customBlock2 = {
    label: 'Nombre del trabajo',
    attributes: {
        class: "gjs-fonts gjs-f-text"
    },
    content: "<div data-gjs-type='text' data-highlightable='1' class='trabajo' >Aquí se muestra el nombre del trabajo</div>",
    id: "myButtonId2"
};

var customBlock3 = {
  label: 'Nombre del evento',
  attributes: {
      class: "gjs-fonts gjs-f-text"
  },
  content: "<div data-gjs-type='text' data-highlightable='1' class='evento' >Aquí se muestra el nombre del evento</div>",
  id: "myButtonId3"
};



var customBlock4 = {
  label: 'Espacio en blanco',
  removable: true,
      draggable: true,
      droppable: true,
      badgable: true,
      stylable: true,
      'stylable-require': '',
      'style-signature': '',
      unstylable: '',
      highlightable: true,
      copyable: true,
      resizable: true,
      editable: true,
      layerable: true,
      selectable: true,
      hoverable: true,
  attributes: {
      class: "gjs-fonts gjs-f-b1",
  },
  content: "<div style='width:100%;height:35px;' ></div>",
  id: "myButtonId4"
};

var customBlock5 = {
  label: 'Logos instituciones',
  attributes: {
      class: "gjs-fonts gjs-f-b1"
  },
  content: imagenes,
  id: "myButtonId5"
};

var customBlock6 = {
  label: '<div>Modalidad de participación</div>',
  attributes: {
      
      class: "gjs-fonts gjs-f-text"
  },
  content: "<div data-gjs-type='text' data-highlightable='1' class='modalidad' style='padding:10px;'>Aquí se muestra la modalidad participación</div>",
  id: "myButtonId6"
};

var bloques = [];
var bloqueCoordinadores = [];
editor.BlockManager.add(customBlock.id, customBlock);
editor.BlockManager.add(customBlock2.id, customBlock2);
editor.BlockManager.add(customBlock3.id, customBlock3);
editor.BlockManager.add(customBlock4.id, customBlock4);
//editor.BlockManager.add(customBlock5.id, customBlock5);
editor.BlockManager.add(customBlock6.id, customBlock6);

for(var k in imagenes) {
  bloqueCoordinadores.push({
    label: '<div style="padding-top:40%;";><strong> ' + imagenes[k][1] + '</strong></div>',
    //label: 'Logos ' + imagenes[k][1],
    attributes: {
        //class: "gjs-fonts gjs-f-image"
    },
    content: imagenes[k][0],
    id: "logo" +k,
    category: "Logos"
  });
  
}

for(var k in coordinadores) {
  bloques.push({
    label: '<div style="padding-top:40%;";><strong> ' + coordinadores[k].siglas + '</strong></div>',
    attributes: {
        
    },
    content: "<div style='padding:10px;'><div data-gjs-type='text'>"+coordinadores[k].coordinador_nombre+"</div><div data-gjs-type='text'>"+coordinadores[k].puesto+"</div></div>",
    id: "coordinador" +k,
    category: "Coordinadores"
  });
  
}

bloques.forEach(element => {
  editor.BlockManager.add(element.id, element);
});

bloqueCoordinadores.forEach(element => {
  editor.BlockManager.add(element.id, element);
});

editor.BlockManager.render([
  bm.get('myButtonId').set('category', 'Iniciales'),
  bm.get('myButtonId2').set('category', 'Iniciales'),
  bm.get('myButtonId3').set('category', 'Iniciales'),
  bm.get('myButtonId4').set('category', 'Iniciales'),
  //bm.get('myButtonId5').set('category', 'Iniciales'),
  bm.get('myButtonId6').set('category', 'Iniciales'),
  
]);


  editor.BlockManager.render([
    bloques,bloqueCoordinadores
    
  ]);


var panelManager = editor.Panels;

panelManager.removeButton("views", "open-tm");
panelManager.removeButton('options', 'preview');
panelManager.removeButton('options', 'fullscreen');
panelManager.removeButton('options', 'export-template');
panelManager.removeButton('options', 'sw-visibility');




panelManager.removeButton("views", "open-layers");
var pnm = editor.Panels;
pnm.addButton("options", [{
id: "undo",
className: "fa fa-undo icon-undo",
command: function command(editor, sender) {
  sender.set("active", 0);
  editor.UndoManager.undo(1);        
},
attributes: {
  title: "Deshacer (CTRL/CMD + Z)"
}
}, {
id: "redo",
className: "fa fa-repeat icon-redo",
command: function command(editor, sender) {
  sender.set("active", 0);
  editor.UndoManager.redo(1);
},
attributes: {
  title: "Repetir (CTRL/CMD + Y)"
}
}]);

/*
var pn = editor.Panels;
// Add and beautify tooltips
[['undo', 'Undo'], ['redo', 'Redo']]
.forEach(function(item) {
 pn.getButton('options', item[0]).set('attributes', {title: item[1], 'data-tooltip-pos': 'bottom'});
});
[['open-sm', 'Style Manager'], ['open-blocks', 'Blocks']]
.forEach(function(item) {
 pn.getButton('views', item[0]).set('attributes', {title: item[1], 'data-tooltip-pos': 'bottom'});
});
*/

editor.runCommand('sw-visibility');

const assetManager = editor.AssetManager;
//assetManager.add

    //am.add('http://img.jpg');
    //am.add(['http://img.jpg', './path/to/img.png']);


editor.addComponents('<style>'+constancia[0].cCSS+'</style>')

editor.getComponents().add(JSON.parse(constancia[0].cComponentes));

/*
var pn = editor.Panels;

[['undo', 'Undo'], ['redo', 'Redo']]
.forEach(function(item) {
 pn.getButton('options', item[0]).set('attributes', {title: item[1], 'data-tooltip-pos': 'bottom'});
});
[['open-sm', 'Style Manager'], ['open-blocks', 'Blocks']]
.forEach(function(item) {
 pn.getButton('views', item[0]).set('attributes', {title: item[1], 'data-tooltip-pos': 'bottom'});
});
var titles = document.querySelectorAll('*[title]');

for (var i = 0; i < titles.length; i++) {
 var el = titles[i];
 var title = el.getAttribute('title');
 title = title ? title.trim(): '';
 if(!title)
   break;
 el.setAttribute('data-tooltip', title);
 el.setAttribute('title', '');
}
*/