
function printTable(printable,options={}) {
    let def = {
        pageTitle: window.document.title, // Title of the page
        importCSS: true, // Import parent page css
        inlineStyle: true, // If true it takes inline style tag
        header: window.document.title, // String or element this will be appended to the top of the printout
        footer: null, // String or element this will be appended to the bottom of the printout
        noPrintClass: "no-print", // Class to remove the elements that should not be printed
    };
    def = Object.assign(def,options);

    if (typeof printout === "function") {
        printout("#"+printable, def);
    }
}

function handelFilter(param= null,value=null){
    const url = new URL(window.location.href)
    const params = new URLSearchParams(url.search)
    if(param !== null && value !== null){
        if(params.has(param)){
            if(params.get(param) === value){
                params.delete(param);
            }else{
                params.set(param,value);
            }
        }else{
            params.append(param,value);
        }
        url.search = params;
    }else{
        url.search = '';
    }
    window.location = url;
}

prevColumn = -1;
prevElement = null;

function prepTableForSort(options={}){
    let sortable = document.querySelectorAll(".sortable");
    sortable.forEach(function(t){
        t.setAttribute('id','sortable_table_'+Math.floor(Math.random() * (10000)));
        prepColumnForSort(t);
    });
}

function prepColumnForSort(table){
    let list = table.querySelector("#sortable_by");
    if(list){
        [...list.children].forEach((child,index)=>{
            if(!child.classList.contains('skip_sort')){
                child.classList.add('clickable');
                child.setAttribute('onclick',`sortTableBy('${index}','${table.getAttribute('id')}',this)` );
            }
        });
    }
}

function sortTableBy(byColumn,tableId,el) {
    sortable = document.querySelector("#"+tableId);
    rows = sortable.rows.length;    
    columns = sortable.rows[0].cells.length; 
    arrTable = [...Array(rows)].map(r => Array(columns));
    
    for (ro=0; ro<rows; ro++) { 
        for (co=0; co<columns; co++) { 
            arrTable[ro][co] = sortable.rows[ro].cells[co].innerHTML;
        }
    }
    header = arrTable.shift(); 

    if (byColumn !== prevColumn) { 
        arrTable.sort((a, b) => {
                if (a[byColumn] === b[byColumn]) {
                    return 0;
                } else {
                    return (a[byColumn] < b[byColumn]) ? -1 : 1;
                }
            }
        );
    } else { 
        arrTable.reverse();
    }
    underline(el,prevElement);
    prevColumn = byColumn; 
    prevElement = el;
    arrTable.unshift(header); 
    for (ro=0; ro<rows; ro++) {
        for (co=0; co<columns; co++) {
            sortable.rows[ro].cells[co].innerHTML = arrTable[ro][co];
        }
    }
    
}

function underline(el,prev=null,reverce=false){
    if(!el.classList.contains('text-primary')){
        el.classList.add('text-primary');
    }else if(reverce){
        el.classList.remove('text-primary');
    }

    if(prev !== null && el !== prev && prev.classList.contains('text-primary')){
        prev.classList.remove('text-primary');
    }
}
