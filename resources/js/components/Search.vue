<template>
    <ais-instant-search :search-client="searchClient" index-name="employees">

        <div class=" flex    mb-1">
              <ais-search-box/>
        </div>
       <ais-hits>
            <div slot="item" slot-scope="{ item }" >

                <div class=" flex border   mb-1">

                    <div class= "  m-2 p-2 py-2 md:w-5/6 ">

                        <a :href="item.path">
                            <p>{{ item.name}} {{ item.surname}}</p>
                        </a>

                    </div>

                    <div class="flex  justify-center md:justify-end md:w-1/6 ">

                        <div class=" px-2 bg-transparent hover:bg-blue-500 text-black-700 hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">
                            <a :href="item.path+'/edit'" >Edytuj</a>
                        </div>

                        <div class="px-2 bg-transparent hover:bg-red-500 text-black-700  hover:text-white border text-indigo-500 hover:border-transparent rounded m-2 py-2 ">

                            <button type="submit" class="">Usuń</button>

                        </div>
                    </div>

                </div>
            </div>
        </ais-hits>
    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';

    export default {
        data() {
            return {
                searchClient: algoliasearch(
                    'KZF9FGD6C6',
                    'f662eefa7b3fd1f6d695ac1568464e68'
                ),
            };
        },
    };
</script>

<style>
    /*.ais-InstantSearch { margin-top: -35px;}*/
.ais-SearchBox {width: 100%;}
.ais-SearchBox-input { border: none;
    width: 30%;
    height: 35px; padding: 12px 20px; float: right; }
.ais-SearchBox-input:focus { outline :none;
    border-bottom: 1px solid #667EEA;
}
    .ais-SearchBox-submitIcon { display: none}
    .ais-SearchBox-reset { display: none}
</style>
