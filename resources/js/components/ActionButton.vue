<template>
    <button
            :data-testid="actionId"
            :dusk="duskId"
            :title="__(action.name)"
            :class="action.classes"
    >
        <span class="mr-1">
          <component
                  :is="`heroicons-outline-${action.icon}`"
                  height="24"
                  width="24"
          />
        </span>
        <span>{{ __(action.name) }}</span>
    </button>
</template>
<script setup>

import {onMounted, ref} from "vue";

const props = defineProps({
    action: {type: Object, required: true}
});

const actionId = ref('');
const duskId = ref('');

onMounted(() => {
    let actionCode = props.action.name.toLowerCase().replace(/ /g, "-");

    actionId.value = `import-action-${actionCode}`;
    duskId.value = `run-action-button-${actionCode}`;
});

</script>
