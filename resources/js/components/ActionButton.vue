<template>
    <button
            :data-testid="actionId"
            :dusk="duskId"
            :title="__(action.name)"
            :class="action.classes ?? 'hover:bg-gray-200 dark:hover:bg-gray-900 flex-shrink-0 rounded focus:outline-none focus:ring inline-flex items-center font-bold px-3 h-9 text-sm flex-shrink-0'"
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
