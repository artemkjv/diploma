<template>
    <div
        class="relative" v-if="data">
        <input
            v-model="value"
            @click="handleSelf"
            @input="handleInput"
            @blur="closeList"
            :placeholder="placeholder"
            ref="input"
            tabindex="0"
            :class="inputClass"
        />
        <span
            v-if="value"
            @click.prevent="reset()"
            class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
        >
      x
    </span>
        <div
            v-show="showOptions"
            @focusout="showOptions = false"
            tabindex="0"
            :class="dropdownClass"
        >
            <ul class="py-1">
                <li
                    v-for="(item, index) in searchResults"
                    :key="index"
                    @click="handleClick(item)"
                    class="px-3 py-2 cursor-pointer hover:bg-gray-200"
                >
                    {{ item[this.keyName] }}
                </li>
                <li v-if="!searchResults.length" class="px-3 py-2 text-center">
                    No Matching Results
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        valueProp: {
            type: Object,
            required: false,
        },
        placeholder: {
            type: String,
            required: false,
            default: "Enter text here.",
        },
        data: {
            type: Array,
            required: true,
        },
        keyName: {
            type: String,
            required: true
        },
        inputClass: {
            type: String,
            required: false,
            default:
                "w-full min-w-[100px] z-20 rounded-md py-2 px-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 bg-transparent !outline-0",
        },
        dropdownClass: {
            type: String,
            required: false,
            default:
                "rich-dropdown-el absolute w-full z-20 bg-white border border-gray-300 mt-1 mh-48 overflow-hidden overflow-y-scroll rounded-md shadow-md",
        },
    },

    data() {
        return {
            showOptions: false,
            chosenOption: "",
            searchTerm: "",
            value: this.valueProp ? this.valueProp[this.keyName] : ''
        };
    },

    computed: {
        searchResults() {
            if(this.searchTerm === '') return this.data
            return this.data.filter((item) => {
                if(item[this.keyName]) {
                    return item[this.keyName].toLowerCase().includes(this.searchTerm.toLowerCase());
                }
            });
        },
    },

    methods: {
        reset() {
            this.value = ''
            this.chosenOption = "";
            this.$emit("chosen", null);
        },

        handleInput(evt) {
            this.$emit("input", evt.target.value);
            this.searchTerm = evt.target.value;
            this.showOptions = true;
        },
        handleSelf(evt) {
            this.showOptions = true
        },

        closeList(evt) {
            if(evt.relatedTarget === null || !evt.relatedTarget.className.includes('rich-dropdown-el')) {
                this.showOptions = false
            }
        },

        handleClick(item) {
            this.value = item[this.keyName]
            this.$emit("chosen", item);
            this.chosenOption = item[this.keyName];
            this.showOptions = false;
            this.$refs.input.focus();
        },

        clickedOutside() {
            this.showOptions = false;

            if (!this.chosenOption) {
                this.$emit("input", "");
            }
        },
    },
};
</script>

<style scoped>
.mh-48 {
    max-height: 10rem;
}
</style>
