<template>
    <div class="form__input">
        <label v-if="label"><b>{{ label }}</b></label><br />
        <div class="control">
            <input
            class="input"
            :type="type" 
            :value="value" 
            :disabled="disabled" 
            @input="updateValue" 
            @change="updateValue" 
            @blur="$emit('blur')" 
            @focus="$emit('focus')"
            />
        </div>
        <p v-if="error" class="form__error">{{ error }}</p>
    </div>

</template>

<script>
export default {
    $_veeValidate: {
    // must not be arrow functions.
    // the name getter
    name () {
      return this.label;
    },
    // the value getter
    value () {
      return this.value; // `this` is the component instance, `value` is the prop we added.
    }
  },

    props: {
        name: {
        type: String
        },
        label: {
        type: String
        },
        error: {
        type: String
        },
        disabled: {
        type: Boolean,
        default: false
        },
        value: String,
        type: {
            type: String,
            default: 'text',
            validate: (val) => {
                return ['text', 'url', 'email', 'password', 'date', 'search'].indexOf(val) !== -1;
            }
        }
    },
    methods: {
        updateValue (e) {
        this.$emit('input', $event.target.value);
        }
    }

}
</script>
