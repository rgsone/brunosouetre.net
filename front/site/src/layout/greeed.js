/*!
 * Greeed.js 1.1.3
 * MIT licensed
 *
 * Copyright (C) 2014 Vincent De Oliveira, http://iamvdo.me
 */

let greeed;

function goGreeed(grid, method, options)
{
	let target = document.querySelector(grid);
	if (target !== null) {
		method.call(null, target, options);
	}
}

function add(grid, options)
{
	greeed = new Greeed(grid, options);
	greeed.init();
}

function remove(grid)
{
	greeed.destroy();
}

function Greeed(elem, options)
{
	this.grid = elem;
	this.nbColumns = 0;
	this.childs = this.columns = this.options = [];

	this.rootFontSize = getComputedStyle(document.documentElement)
		.getPropertyValue('font-size')
		.replace('px', '');

	for (let key in options) {
		if (options.hasOwnProperty(key)) {
			this.defaults[key] = options[key];
		}
	}

	this.options = this.defaults;
}

Greeed.prototype = {

	defaults: {
		elementColumn: 'li',
		elementColumnInner: 'ul',
		classColumn: 'Greeed-column',
		classColumnInner: 'Greeed-column-inner',
		classItem: 'Greeed-item',
		classFakeItem: 'Greeed-item--fake',
		layout: 'table',
		units: 'fluid'
	},

	init() {
		// Get elements
		this.childs = Array.prototype.slice.call(this.grid.children);
		// DOM columns
		this.columnsDOM = [];

		this.checkMQ();

		let scope = this;
		this.startCheckMQ = function(event) { scope.checkMQ(event); };

		window.addEventListener('resize', this.startCheckMQ, false);

		if (this.options.afterInit) {
			this.options.afterInit();
		}
	},

	destroy() {
		window.removeEventListener('resize', this.startCheckMQ, false);
	},

	createColumns(greeedWidth) {
		// create an Array of columns
		this.columns = new Array(this.nbColumns);

		for (let i = 0; i < this.nbColumns; i++) {
			this.columns[i] = [];
			// set height
			this.columns[i]._offsetHeight = 0;
		}

		for (let i = 0; i < this.childs.length; i++) {
			// find the smallest column to place the next child
			let columnsHeight = [];

			for (let j = 0; j < this.columns.length; j++) {
				let columnHeight = this.columns[j]._offsetHeight;
				columnsHeight.push(columnHeight);
			}

			let smallestColumnIndex = columnsHeight.indexOf(Math.min.apply(Math, columnsHeight));

			// add child to the smallest height column
			this.columns[smallestColumnIndex].push(this.childs[i]);
			// add an id (keep the old position)
			this.childs[i]._id = i;
			// update column height
			this.columns[smallestColumnIndex]._offsetHeight += this.childs[i].offsetHeight;
		}

		// find the max-height column
		let maxHeightColumn = 0;
		for (let i = 0; i < this.columns.length; i++) {
			let height = this.columns[i]._offsetHeight;
			if (height >= maxHeightColumn) maxHeightColumn = height;
		}

		let grid = document.createDocumentFragment();

		for (let i = 0; i < this.columns.length; i++) {
			let column = document.createElement(this.options.elementColumn);
			column.className = this.options.classColumn;

			if (this.options.layout === 'table') {
				column.style.display = 'table-cell';
				column.style.verticalAlign = 'top';
			} else {
				column.style.styleFloat = column.style.cssFloat = 'left';
				column.style.display = 'block';

				if (this.options.units === 'fixed') {
					column.style.width = Math.floor(greeedWidth / this.nbColumns) + 'px';
				} else {
					column.style.width = (100 / this.nbColumns) + '%';
				}
			}

			let columnElement;

			if (this.options.elementColumnInner) {
				columnElement = document.createElement(this.options.elementColumnInner);
				columnElement.className = this.options.classColumnInner;
			} else {
				columnElement = column;
			}

			for (let j = 0; j < this.columns[i].length; j++) {
				this.columns[i][j].classList.add(this.options.classItem);
				columnElement.appendChild(this.columns[i][j]);
			}

			if (this.columns[i]._offsetHeight < maxHeightColumn && this.options.classFakeItem) {
				let fake_elem = document.createElement(this.options.elementColumn);
				fake_elem.className = this.options.classItem + ' ' + this.options.classFakeItem;
				fake_elem.style.height = maxHeightColumn - this.columns[i]._offsetHeight + 'px';
				columnElement.appendChild(fake_elem);
			}

			if (this.options.elementColumnInner) {
				column.appendChild(columnElement);
			}

			// add the column to the DOM columns array
			this.columnsDOM[i] = column;

			grid.appendChild(column);
		}

		this.grid.innerHTML = '';
		this.grid.appendChild(grid);

		if (this.options.layout === 'table') {
			this.grid.style.display = 'table';
			this.grid.style.tableLayout = 'fixed';
		}

		if(this.options.afterLayout) {
			this.options.afterLayout();
		}
	},

	setColumnsWidth(greeedWidth) {
		// update width to match parent width
		let newColumnWidth = Math.floor(greeedWidth / this.nbColumns);
		let greeedWidthCalc = newColumnWidth * this.nbColumns;
		let pixelsLeft = greeedWidth - greeedWidthCalc;

		for (let i = 0; i < this.columnsDOM.length; i++) {
			let colWidth = (pixelsLeft > 0) ? newColumnWidth + 1 : newColumnWidth;
			pixelsLeft--;
			this.columnsDOM[i].style.width = colWidth + 'px';
		}
	},

	checkMQ(event) {
		let lastNbColumns = this.nbColumns;
		this.windowWidth = window.innerWidth;

		// for each breakpoints
		for (let i = 0; i < this.options.breakpoints.length; i++) {
			let point = this.options.breakpoints[i],
					size = point * this.rootFontSize;

			// set how many columns to create
			if (window.innerWidth < size) {
				this.nbColumns = i + 1;
				break;
			} else {
				this.nbColumns = i + 2;
			}
		}

		if (this.options.units === 'fixed') {
			// Get the width of the greeed, every time
			let greeedWidth = Math.floor(getComputedStyle(this.grid)
				.getPropertyValue('width')
				.replace('px',''));

			// create columns
			this.createColumns( greeedWidth );
			// set columns width, every time
			this.setColumnsWidth( greeedWidth );
		} else {
			// create columns
			this.createColumns();
		}
	}
}

export default greeed = {
	bind(elem, options) {
		goGreeed(elem, add, options);
	},
	unbind(elem) {
		goGreeed(elem, remove);
	}
};
