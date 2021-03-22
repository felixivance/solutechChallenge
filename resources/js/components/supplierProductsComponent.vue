
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
                                        <strong class="card-title text-light">Suppliers Products</strong>
                                    </div>
                                    <div class="col-md-2">
                                        <button @click="openModal" type="button" class="btn btn-primary">Add Supplier Product</button>
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
                                                supplier Products
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
                                        <b-button @click="deleteSupplierProduct(row.item.id)" class="btn btn-sm" variant="danger">
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
                        <h5 v-if="!editMode" class="modal-title" id="mediumModalLabel">Add Supplier Product</h5>
                        <h5 v-else class="modal-title" id="mediumModalLabel">Update Supplier Product</h5>
                    </div>
                    <form @submit.prevent="editMode ? updateSupplierProduct() : addSupplierProduct()">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="select" class="form-control-label">Select Product:</label>
                                        <select v-model="form.product_id" name="select" id="select" class="form-control">
                                            <option v-for="(product,i) in products" :key="i" :value="product.id">{{product.name}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="selectSupplier" class="form-control-label">Select Supplier:</label>
                                        <select v-model="form.supply_id" name="select" id="selectSupplier" class="form-control">
                                            <option v-for="(supplier,i) in suppliers" :key="i" :value="supplier.id">{{supplier.name}}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button v-if="!editMode" type="submit" class="btn btn-primary">Add Supplier Product</button>
                            <button v-else type="submit" class="btn btn-primary">Update Supplier Product</button>
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
            fields: ['#', {key:'supplier.name', label:'Supplier Name'},
                {key:'product.name', label:'Product'},
                'actions'],
            items: [],
            suppliers: [],
            products: [],
            perPage: 10,
            currentPage: 1,
            filter: null,
            totalRows: 1,
            editMode: false,
            form: new Form({
                product_id: '',
                supply_id: '',
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
        openEditModal(supplier) {
            $('#mediumModal').modal('show');
            this.editMode = true;
            this.form.fill(supplier)
            // console.log(this.form);
        },
        async  getSupplierProducts() {
            await  axios.get('/api/supplierProducts').then(({ data }) => {
                // console.log(data)
                this.items = data.data;
                this.totalRows = this.items.length
            }).catch((error) => {
                console.log(error);
            });
        },
        async  getProducts() {
            await  axios.get('/api/products').then(({ data }) => {
                // console.log(data)
                this.products = data.data;

            }).catch((error) => {
                console.log(error);
            });
        },
        async  getSuppliers() {
            await  axios.get('/api/suppliers').then(({ data }) => {
                // console.log(data)
                this.suppliers = data.data;
            }).catch((error) => {
                console.log(error);
            });
        },
        async addSupplierProduct() {
            await  axios.post('/api/supplierProducts/', this.form).then(({ data }) => {
                // console.log(data);
                if (data.success) {
                    this.form.reset();
                    this.getSupplierProducts();
                    $('#mediumModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Supplier product added.',
                        showConfirmButton: true,
                    });
                }
            }).catch((error) => {
                console.log(error);
            });
        },

        async  updateSupplierProduct() {
            await   axios.put('/api/supplierProducts/' + this.form.id, this.form).then(({ data }) => {
                // console.log(data);
                if (data.success) {
                    this.form.reset();
                    this.getSupplierProducts();
                    $('#mediumModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Supplier product updated.',
                        showConfirmButton: true,
                    });
                }
            }).catch((error) => {
                console.log(error);
            });
        },
        async  deleteSupplierProduct(id) {
            await   Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete supplier product!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(id);
                    axios.delete('/api/supplierProducts/' + id,).then(({ data }) => {
                        // console.log(data);
                        if (data.success) {
                            this.form.reset();
                            this.getSupplierProducts();
                            $('#mediumModal').modal('hide');
                            Swal.fire(
                                'Deleted!',
                                'Supplier product has been deleted.',
                                'success'
                            )
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
                }
            })
        },

    },
    mounted() {
        this.getSupplierProducts();
        this.getProducts();
        this.getSuppliers()
    },
}
</script>
