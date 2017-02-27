@extends('layouts.app')
@section('content')

<div class="container" id="manage-vue">

    <div class="row">
        <div class="col-lg-6 margin-tb">
            <div class="pull-left">
                <h2>My contact book</h2>
            </div>
        </div>
            <div class="col-lg-12 pull-right">
                <div class="row">
                    <div class="col-xs-3">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#search-item">
                            Search Contacts
                        </button>
                    </div>
                    <div class=" col-xs-3">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
                            Create Contact
                        </button>
                    </div>
                    <div class="col-xs-3">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-group">
                          Add Group
                        </button>
                    </div>
                    <div class="col-xs-3">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#delete-group">
                            Delete Group
                        </button>
                    </div>
                </div>
            </div>

    </div>
    <br>
    <!-- Contact Listing -->
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Groups</th>

            <th width="200px">Action</th>
        </tr>
        <tr v-for="item in items">
            <td>@{{ item.name }}</td>
            <td>@{{ item.surname }}</td>
            <td>@{{ item.email }}</td>
            <td>@{{ item.phone }}</td>
            <td>
                <div v-for="group in item.groups">@{{group.name}}</div>
            </td>

            <td>
                <button class="btn btn-primary" @click.prevent="editItem(item)">Edit</button>
                <button class="btn btn-danger" @click.prevent="deleteItem(item)">Delete</button>
            </td>
        </tr>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <li v-if="pagination.current_page > 1">
                <a href="#" aria-label="Previous"
                   @click.prevent="changePage(pagination.current_page - 1)">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <li v-for="page in pagesNumber"
                v-bind:class="[ page == isActived ? 'active' : '']">
                <a href="#"
                   @click.prevent="changePage(page)">@{{ page }}</a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page">
                <a href="#" aria-label="Next"
                   @click.prevent="changePage(pagination.current_page + 1)">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Create Contact Modal -->
    <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Create Item</h4>
                </div>
                <div class="modal-body">

                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">

                        <div class="form-group">
                            <label for="title">Name:</label>
                            <input type="text" name="name" class="form-control" v-model="newItem.name"/>
                            <span v-if="formErrors['name']" class="error text-danger">@{{ formErrors['name'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="title">Surname:</label>
                            <input type="text" name="surname" class="form-control" v-model="newItem.surname"/>
                            <span v-if="formErrors['surname']"
                                  class="error text-danger">@{{ formErrors['surname'] }}</span>
                        </div>


                        <div class="form-group">
                            <label for="title">Email:</label>
                            <input type="text" name="email" class="form-control" v-model="newItem.email"/>
                            <span v-if="formErrors['email']" class="error text-danger">@{{ formErrors['email'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="title">Phone:</label>
                            <input type="text" name="phone" class="form-control" v-model="newItem.phone"/>
                            <span v-if="formErrors['phone']" class="error text-danger">@{{ formErrors['phone'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="title">Groups:</label>
                            <v-select :value.sync="newItem.groups" label="name" multiple :options="groups"/>
                            <span v-if="formErrors['groups']"
                                  class="error text-danger">@{{ formErrors['groups'] }}</span>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>

    <!-- Edit Contact Modal -->
    <div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
                </div>
                <div class="modal-body">

                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">

                        <div class="form-group">
                            <label for="title">Name:</label>
                            <input type="text" name="name" class="form-control" v-model="fillItem.name"/>
                            <span v-if="formErrorsUpdate['name']" class="error text-danger">@{{ formErrorsUpdate['name'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="title">Surname:</label>
                            <input type="text" name="surname" class="form-control" v-model="fillItem.surname"/>
                            <span v-if="formErrorsUpdate['surname']"
                                  class="error text-danger">@{{ formErrorsUpdate['surname'] }}</span>
                        </div>


                        <div class="form-group">
                            <label for="title">Email:</label>
                            <input type="text" name="email" class="form-control" v-model="fillItem.email"/>
                            <span v-if="formErrorsUpdate['email']" class="error text-danger">@{{ formErrorsUpdate['email'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="title">Phone:</label>
                            <input type="text" name="phone" class="form-control" v-model="fillItem.phone"/>
                            <span v-if="formErrorsUpdate['phone']" class="error text-danger">@{{ formErrorsUpdate['phone'] }}</span>
                        </div>


                        <div class="form-group">
                            <label for="title">Groups:</label>
                            <v-select id="editGroup" :value.sync="fillItem.groups" label="name" multiple
                                      :options="groups"/>
                            <span v-if="formErrorsUpdate['groups']"
                                  class="error text-danger">@{{ formErrorsUpdate['groups'] }}</span>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Search Contact Modal -->
    <div class="modal fade" id="search-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Search contacts</h4>
                </div>
                <div class="modal-body">

                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="searchItem">

                        <div class="form-group">
                            <label for="title">Name:</label>
                            <input type="text" name="name" class="form-control" v-model="newItem.name"/>
                            <span v-if="formErrors['name']" class="error text-danger">@{{ formErrors['name'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="title">Surname:</label>
                            <input type="text" name="surname" class="form-control" v-model="newItem.surname"/>
                            <span v-if="formErrors['surname']"
                                  class="error text-danger">@{{ formErrors['surname'] }}</span>
                        </div>


                        <div class="form-group">
                            <label for="title">Email:</label>
                            <input type="text" name="email" class="form-control" v-model="newItem.email"/>
                            <span v-if="formErrors['email']" class="error text-danger">@{{ formErrors['email'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="title">Phone:</label>
                            <input type="text" name="phone" class="form-control" v-model="newItem.phone"/>
                            <span v-if="formErrors['phone']" class="error text-danger">@{{ formErrors['phone'] }}</span>
                        </div>

                        <div class="form-group">
                            <label for="title">Groups:</label>
                            <v-select :value.sync="newItem.groups" label="name" multiple :options="groups"/>
                            <span v-if="formErrors['groups']"
                                  class="error text-danger">@{{ formErrors['groups'] }}</span>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>
    <!-- Add group -->

    <div class="modal fade" id="add-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Group</h4>
                </div>
                <div class="modal-body">

                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="addGroup">

                        <div class="form-group">
                            <label for="title">Name:</label>
                            <input type="text" name="name" class="form-control" v-model="newGroup.name"/>
                            <span v-if="formErrors['name']" class="error text-danger">@{{ formErrors['name'] }}</span>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Delete group -->

    <div class="modal fade" id="delete-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete Group</h4>
                </div>
                <div class="modal-body">

                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="deleteGroup">

                        <div class="form-group">
                            <label for="title">Name:</label>
                            <v-select :value.sync="deleteGroupID" label="name"  :options="groups"/>
                            <span v-if="formErrors['name']" class="error text-danger">@{{ formErrors['name'] }}</span>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Delete</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/vue.resource/0.9.3/vue-resource.min.js"></script>

<script src="https://unpkg.com/vue-select@1.3.3"></script>

<script type="text/javascript" src="js/vueContact.js"></script>

@endsection