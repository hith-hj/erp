
function printTable(printable, options = {}) {
    let def = {
        pageTitle: window.document.title, // Title of the page
        importCSS: true, // Import parent page css
        inlineStyle: true, // If true it takes inline style tag
        header: window.document.title, // String or element this will be appended to the top of the printout
        footer: null, // String or element this will be appended to the bottom of the printout
        noPrintClass: "no-print", // Class to remove the elements that should not be printed
    };
    def = Object.assign(def, options);

    if (typeof printout === "function") {
        printout("#" + printable, def);
    }
}

function handelFilter(param = null, value = null) {
    const url = new URL(window.location.href)
    const params = new URLSearchParams(url.search)
    if (param !== null && value !== null) {
        if (params.has(param)) {
            if (params.get(param) === value) {
                params.delete(param);
            } else {
                params.set(param, value);
            }
        } else {
            params.append(param, value);
        }
        url.search = params;
    } else {
        url.search = '';
    }
    window.location = url;
}

// prevColumn = -1;
// prevElement = null;

let prevColumn = null;
let prevElement = null;
let isDescending = false;

function prepTableForSort(options = {}) {
    let sortable = document.querySelectorAll(".sortable");
    sortable.forEach(function (t) {
        t.setAttribute('id', 'sortable_table_' + Math.floor(Math.random() * (10000)));
        prepColumnForSort(t);
    });
}

function prepColumnForSort(table) {
    let list = table.querySelector("#sortable_by");
    if (list) {
        [...list.children].forEach((child, index) => {
            if (!child.classList.contains('skip_sort')) {
                child.classList.add('clickable');
                child.setAttribute('onclick', `sortTableBy('${index}','${table.getAttribute('id')}',this)`);
            }
        });
    }
}

function sortTableBy(byColumn, tableId, el) {
    const table = document.getElementById(tableId);
    if (!table) return;

    const currentHeader = el.closest('th');
    const tbody = table.querySelector('tbody') || table;
    const rowsArray = Array.from(tbody.querySelectorAll('tr'));

    if (byColumn === prevColumn) {
        isDescending = !isDescending;
    } else {
        isDescending = false;
    }

    // 1. Manage Indicator Icons
    table.querySelectorAll('th .sort-indicator').forEach(span => span.remove());
    const indicator = document.createElement('span');
    indicator.className = 'sort-indicator ms-1';
    indicator.textContent = isDescending ? ' ▼' : ' ▲';
    if (currentHeader) currentHeader.appendChild(indicator);

    // 2. Sort Logic with Date Handling
    rowsArray.sort((rowA, rowB) => {
        const cellA = rowA.cells[byColumn]?.textContent.trim() || '';
        const cellB = rowB.cells[byColumn]?.textContent.trim() || '';

        // Attempt to parse as dates first
        // Exclude pure numbers from Date.parse (e.g., "1250" shouldn't become a timestamp)
        const isAStringNumber = !isNaN(cellA.replace(/[^\d.-]/g, '')) && !cellA.includes('-');
        const isBStringNumber = !isNaN(cellB.replace(/[^\d.-]/g, '')) && !cellB.includes('-');

        const timeA = (!isAStringNumber && Date.parse(cellA)) ? Date.parse(cellA) : NaN;
        const timeB = (!isBStringNumber && Date.parse(cellB)) ? Date.parse(cellB) : NaN;

        let comparison = 0;

        if (!isNaN(timeA) && !isNaN(timeB)) {
            // Both are valid dates, sort chronologically
            comparison = timeA - timeB;
        } else {
            // Fallback to numeric or text processing
            const numA = parseFloat(cellA.replace(/[^\d.-]/g, ''));
            const numB = parseFloat(cellB.replace(/[^\d.-]/g, ''));

            if (!isNaN(numA) && !isNaN(numB)) {
                comparison = numA - numB;
            } else {
                comparison = cellA.localeCompare(cellB, undefined, { numeric: true, sensitivity: 'base' });
            }
        }

        return isDescending ? -comparison : comparison;
    });

    // 3. Render back to DOM
    const fragment = document.createDocumentFragment();
    rowsArray.forEach(row => fragment.appendChild(row));
    tbody.appendChild(fragment);

    if (typeof underline === 'function') {
        underline(el, prevElement);
    }

    prevColumn = byColumn;
    prevElement = el;
}


function underline(el, prev = null, reverce = false) {
    if (!el.classList.contains('text-primary')) {
        el.classList.add('text-primary');
    } else if (reverce) {
        el.classList.remove('text-primary');
    }

    if (prev !== null && el !== prev && prev.classList.contains('text-primary')) {
        prev.classList.remove('text-primary');
    }
}
