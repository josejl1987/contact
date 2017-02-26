

Vue.http.headers.common['X-CSRF-TOKEN'] = $("#token").attr("value");

Vue.component('v-select', VueSelect.VueSelect);

var myVue=new Vue({

    el: '#manage-vue',

    data: {
        items: [],
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,
        formErrors:{},
        formErrorsUpdate:{},
        groups:[],
        searchFilter:{},
        deleteGroupID:'',
        newGroup : {'name':''},
        fillGroup : {'id':'','name':''},
        newItem : {'name':'','surname':'','email':'','phone':'','groups':''},
        fillItem : {'id':'','name':'','surname':'','email':'','phone':'','groups':''}
    },

    computed: {



        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },

    ready : function(){
        this.getVueItems(this.pagination.current_page);
    },

    methods : {

        getVueItems: function(page){

            this.$http.get('/group').then((response) => {
                this.$set('groups', response.data);
            this.deleteGroupID=this.groups[0];

        });


            this.$http.get('/vuecontact?page='+page,{params:this.searchFilter}).then((response) => {
                this.$set('items', response.data.data.data);
            this.$set('pagination', response.data.pagination);
        });
        },

        searchItem: function(){
            this.searchFilter = this.newItem;

            this.$http.get('/vuecontact/search',{params:this.searchFilter}).then((response) => {
                this.changePage(this.pagination.current_page);
            this.newItem = {'name':'','surname':'','email':'','phone':'','groups':''};
            $("#search-item").modal('hide');
            this.formErrors={};
        }, (response) => {
                this.formErrors = response.data;

            });
        },

        addGroup: function(){
            var input = this.newGroup;
            var groupIDs=[];
                   input.groups=groupIDs;
            this.$http.post('/group',input).then((response) => {
                this.changePage(this.pagination.current_page);
            this.newGroup = {'name':''};
            $("#add-group").modal('hide');
            toastr.success('Group Created Successfully.', 'Success Alert', {timeOut: 5000});
            this.formErrors={};
        }, (response) => {
                this.formErrors = response.data;
            });
        },


        createItem: function(){
            var input = jQuery.extend({}, this.newItem)
            var groupIDs=[];
           for(var i=0;i<this.newItem.groups.length;i++){
              groupIDs.push(this.newItem.groups[i]['id']);
           }
            input.groups=groupIDs;
            this.$http.post('/vuecontact',input).then((response) => {
                this.changePage(this.pagination.current_page);
            this.newItem = {'name':'','surname':'','email':'','phone':'','groups':''};
            $("#create-item").modal('hide');
            this.formErrors={};
            toastr.success('Contact Created Successfully.', 'Success Alert', {timeOut: 5000});
        }, (response) => {
                this.formErrors = response.data;
            });
        },



        deleteItem: function(item) {
            this.$http.delete('/vuecontact/' + item.id).then((response) => {
                this.changePage(this.pagination.current_page);

            toastr.success('Contact Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        })
            ;
        },


        deleteGroup: function(item){

            this.$http.delete('/group/'+this.deleteGroupID.id).then((response) => {
                this.changePage(this.pagination.current_page);
            $("#delete-group").modal('hide');
            this.deleteGroupID=groups[0];
            this.$http.get('/group').then((response) => {
                this.$set('groups', response.data);
        });
            toastr.success('Group Deleted Successfully.', 'Success Alert', {timeOut: 5000});
        });
        },

        editItem: function(item){
            this.fillItem.id = item.id;
            this.fillItem.name = item.name;
            this.fillItem.surname = item.surname;
            this.fillItem.email = item.email;
            this.fillItem.phone = item.phone;
            this.fillItem.groups = item.groups;

            $("#edit-item").modal('show');
        },

        updateItem: function(id){

            var input = jQuery.extend({}, this.fillItem)
            var groupIDs=[];
            for(var i=0;i<input.groups.length;i++){
                groupIDs.push(this.fillItem.groups[i]['id']);
            }
            input.groups=groupIDs;

            this.$http.put('/vuecontact/'+id,input).then((response) => {
                this.changePage(this.pagination.current_page);
            this.fillItem = {'id':'','name':'','surname':'','email':'','phone':'','groups':''};
            $("#edit-item").modal('hide');
            this.formErrorsUpdate = {}

            toastr.success('Contact Updated Successfully.', 'Success Alert', {timeOut: 5000});
        }, (response) => {
                this.formErrorsUpdate = response.data;
            });
        },

        changePage: function (page) {
            this.pagination.current_page = page;
            this.getVueItems(page);
        }

    }

});

