<template>
<v-app>
    <div class="account-management" >
        <!-- Table Account -->
        <v-card>
            <v-card-title> Account list <v-spacer></v-spacer>
                <v-text-field v-model="search" append-icon="mdi-account-search" label="Search" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="sortedAccounts" :search="search" 
            :footer-props="{'items-per-page-options': [25, 50, 100, 200, -1]
            }"
            item-key="id"
            @click:row="selectAccount" single-select
            >
            <template #item.actions="{item}">
                <td @click.stop class="non-clickable">
                <v-btn small >View</v-btn>
                <v-btn small >Edit</v-btn>
                <v-btn color="red" small @click="selectdete(item)">Delete</v-btn>
                </td>
            </template>
            <template v-slot:no-results>
                <v-alert :value="true" color="error" icon="mdi-alert">
                Your search for "{{ search }}" found no results.
                </v-alert>
            </template>
            </v-data-table>
        </v-card>
        <!-- <v-simple-table class="tb-account" ref="table" dark>
            <thead>
                <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Email</th>
                <th class="text-left">Role</th>
                <th class="text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="account in sortedAccounts" :key="account.id" @click="selectAccount(account)" :class="{'selectedRow': account == selectedAccount}">
                <td>{{ account.name }}</td>
                <td>{{ account.email }}</td>
                <td>{{ account.role }}</td> 
                <td><v-icon medium color="red" @click="alertDelete = true">mdi-delete</v-icon></td>               
                </tr>
            </tbody>
        </v-simple-table> -->
    </div>
</v-app>
</template>

<script>
    export default {
        props: {
        },
        data: () =>({
            accounts: [],
            search: '',
            headers: [
            {
                text: 'ID',
                align: 'left',
                sortable: false,
                value: 'id'
            },
            { text: 'Name', value: 'account_name' },
            { text: 'Phone', value: 'phone' },
            { text: 'Region name', value: 'region_name' },
            { text: 'Action', value: 'actions' },
            ],
            selectedAccount: null,

        }),
        mounted() {
            axios.get('/accounts')
                .then((response) => {
                  if(response.status === 200)
                  {
                      this.accounts = response.data.success.message;
                      console.log(this.accounts);
                  }
                }).catch((error)=>{
                    console.log(response.error);
                });
        },
        computed: {
                sortedAccounts() {
                return _.orderBy(this.accounts, ['updated_at'], ['desc']);
            }        
        },
        methods: {
            
            selectAccount(account, row) {
                row.select(true);
                this.name = account.name;
                this.email = account.email;
                this.select = { id: '' + account.role +'' },
                this.selectedAccount = account;
            },
            selectdete(item) {
                alert(item.name);
            }
        },
    }
</script>
 <style lang="scss" scoped>
    .tb-account {
        margin-top: 20px;
    }
    .register-form {
        width: 100%;
    }
    .txtGroup {
        display: flex;
        .txtGroup1 {
            width: 40%;
        }
    }
    .btnGroup {
        margin-left: 5%;
        width: 40%;
        .btnGroup1 {
            display: flex;
        }
    }
    .selectedRow {
        background-color: goldenrod;
        font-weight: bold;
    }

 </style>
 
