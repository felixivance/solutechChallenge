
<template>
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
            <!-- Widgets  -->
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-10">
                                        <strong class="card-title text-light">Products</strong>
                                    </div>
                                    <div class="col-md-2">
                                        <button @click="openModal" type="button" class="btn btn-primary">Add Product</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="dataTables_length" id="bootstrap-data-table_length">
                                            <label> Show
                                                <select v-model="perPage" name="bootstrap-data-table_length" aria-controls="bootstrap-data-table" class="form-control form-control-sm">
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <!-- <option value="-1">All</option> -->
                                                </select>
                                                products
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <b-input-group>
                                            <b-form-input id="filter-input" v-model="filter" type="search" placeholder="Type to Search"></b-form-input>
                                            <b-input-group-append>
                                                <b-button variant="dark" :disabled="!filter" @click="filter = ''">Clear</b-button>
                                            </b-input-group-append>
                                        </b-input-group>

                                    </div>
                                </div>
                                <br/>
                                <b-table bordered :items="items" :per-page="perPage" :current-page="currentPage" :fields="fields" :filter="filter" show-empty @filtered="onFiltered">
                                    <template v-slot:cell(actions)="row">
                                        <b-button class="btn btn-sm" variant="success" @click="openEditModal(row.item)">
                                            Edit
                                        </b-button>
                                        &nbsp;
                                        <b-button @click="deleteProduct(row.item.id)" class="btn btn-sm" variant="danger">
                                            Delete
                                        </b-button>
                                    </template>

                                    <template v-slot:cell(#)="row">
                                        <p>{{row.index + 1}}</p>
                                    </template>
                                </b-table>
                                <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" aria-controls="my-table"></b-pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 v-if="!editMode" class="modal-title" id="mediumModalLabel">Add Product</h5>
                        <h5 v-else class="modal-title" id="mediumModalLabel">Update Product</h5>
                    </div>
                    <form @submit.prevent="editMode ? updateProduct() : addProduct()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company" class="form-control-label">Product Name:</label>
                                        <input required v-model="form.name" type="text" id="company" placeholder="Enter product Name" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label  class="form-control-label">Product Quantity:</label>
                                        <input required v-model="form.quantity" type="number" placeholder="Enter quantity" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label  class="form-control-label">Description</label>
                                        <textarea v-model="form.description" id="" cols="30" rows="10" class="form-control"></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button v-if="!editMode" type="submit" class="btn btn-primary">Add Product</button>
                            <button v-else type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import $ from 'jquery';
export default {
    data() {
        return {
            fields: ['#', 'name','quantity',
                {key:'description', label:'Description'},'actions'],
            items: [],
            genders: [],
            services: [],
            perPage: 10,
            currentPage: 1,
            filter: null,
            totalRows: 1,
            editMode: false,
            form: new Form({
                id: '',
                name: '',
                quantity:'',
                description: '',
            })
        }
    },
    computed: {
        rows() {
            return this.items.length
        }
    },
    methods: {
        onFiltered(filteredItems) {
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },
        openModal() {
            $('#mediumModal').modal('show');
            this.editMode = false;
        },
        openEditModal(product) {
            $('#mediumModal').modal('show');
            this.editMode = true;
            this.form.fill(product)
            // console.log(this.form);
        },
        async  getProducts() {
            await  axios.get('/api/products').then(({ data }) => {
                // console.log(data)
                this.items = data.data;
                this.totalRows = this.items.length
            }).catch((error) => {
                console.log(error);
            });
        },
        async addProduct() {
            await  axios.post('/api/products/', this.form).then(({ data }) => {
                // console.log(data);
                if (data.success) {
                    this.form.reset();
                    this.getProducts();
                    $('#mediumModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Product added.',
                        showConfirmButton: true,
                    });
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        async  updateProduct() {
            await   axios.put('/api/products/' + this.form.id, this.form).then(({ data }) => {
                // console.log(data);
                if (data.success) {
                    this.form.reset();
                    this.getProducts();
                    $('#mediumModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Product updated.',
                        showConfirmButton: true,
                    });
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        async  deleteProduct(id) {
            await   Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete product!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(id);
                    axios.delete('/api/products/' + id,).then(({ data }) => {
                        // console.log(data);
                        if (data.success) {
                            this.form.reset();
                            this.getProducts();
                            $('#mediumModal').modal('hide');
                            Swal.fire(
                                'Deleted!',
                                'Product has been deleted.',
                                'success'
                            )
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
                }
            })
        },
        async  getGenders() {
            await   axios.get('/api/genders').then(({ data }) => {
                // console.log(data)
                this.genders = data.data;
            }).catch((error) => {
                console.log(error);
            });
        },
        async  getServices() {
            await  axios.get('/api/services').then(({ data }) => {
                // console.log(data)
                this.services = data.data;
            }).catch((error) => {
                console.log(error);
            });
        },
    },
    mounted() {
        this.getProducts();

    },
}
</script>
