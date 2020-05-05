<template>
    <ais-instant-search
        :search-client="searchClient"
        index-name="demo_ecommerce"
    >
    </ais-instant-search>
</template>

<script>
    import algoliasearch from 'algoliasearch/lite';

    export default {
        data() {
            return {
                searchClient: algoliasearch(
                    'KZF9FGD6C6',
                    '989f9829affc7321d8489c5fe057e05d'
                ),
            };
        },
    };
</script>
