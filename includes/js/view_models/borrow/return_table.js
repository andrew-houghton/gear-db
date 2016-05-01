

var ViewModel = function(data){
	var self = this;
	self.initialData = data;
	self.rowData = ko.observableArray();
	self.fieldsList = ko.observableArray();
	
	self.init = function() {
		self.generateArrays();
		self.refreshDatatable();
		
	};

	self.generateArrays = function(){
		for(var index in data['rows']){
			self.rowData.push(new RecordViewModel(data['rows'][index]));
		}
		for(var index in data['Fields']){
			self.fieldsList.push(new RecordViewModel(data['Fields'][index]));
		}
	}


	self.refreshDatatable = function() {

		//Create the columns array from the data sent from the controller.
		columnsArr = [];
		for(var index in self.fieldsList()){
			var field=self.fieldsList()[index]['Fields'];
			if (field==='returned'){
				var functionStr="if (row['"+field+"']==1){return 'Yes';}else{return 'No';}";
			} else if (field==='date_return'){
				var functionStr="if (row['date_return']=='0000-00-00'){return 'Not returned';}else{return row['date_return'];}";
			} else {
				var functionStr="return row['"+field+"'];";
			}
			var tempFunc=Function("row",functionStr);  //Create a tempoary function to return the right field in each column

			columnsArr.push({"data": tempFunc, //Assign the data of this column to the return value of the function
		            title: self.fieldsList()[index]['DisplayName'] //Assign the heading of the field to the display name
		        });
		}

		self.table = $("#dataTable").DataTable({ //Put the columns and the data into the datatable
			data: self.rowData(),
			columns: columnsArr,
			stateSave: false,
			dom: '<"left"l>fBrtip',
			buttons: [],
			fixedHeader: true
	        // "pagingType": "full_numbers"
		});

		$("#dataTable").on('click', 'tbody tr', function(e){
			//Link each row to the gear return page
			window.document.location = base_url+'borrow/gear_return/'+self.table.row( this ).data().borrow_group_id;
		});
	}

	$(document).ready(function() {
	    // Setup - add a text input to each footer cell
	    $('#example tfoot th').each( function () {
	        var title = $(this).text();
	        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
	    } );
	 
	    // DataTable
	    var table = self.table

	    console.log(table);
	 
	    // Apply the search
	    table.columns().every( function () {
	        var that = this;

	        console.log(this);
	 
	        $( 'input', this.footer() ).on( 'keyup change', function () {
	            if ( that.search() !== this.value ) {
	                that
	                    .search( this.value )
	                    .draw();
	            }
	        } );
	    } );
	} );
}


var RecordViewModel = function(data){
	var self = this;
	self.initialData = data;

	for(var field in data){
		var val = data[field];
		// self[field] = ko.observable(val);
		self[field] = val;
	}

}

