<template>
    <!-- Confirm Action Modal -->
    <component
        v-if="actionModalVisible"
        :show="actionModalVisible"
        class="text-left"
        :is="selectedAction?.component"
        :working="working"
        :selected-resources="selectedResources"
        :resource-name="resourceName"
        :action="selectedAction"
        :errors="errors"
        @confirm="runAction"
        @close="closeConfirmationModal"
    />

    <component
        v-if="responseModalVisible"
        :show="responseModalVisible"
        :is="actionResponseData?.modal"
        @confirm="handleResponseModalConfirm"
        @close="handleResponseModalClose"
        :data="actionResponseData"
    />

    <ActionButton
            v-for="action in actions"
            @click="() => handleActionClick(action.uriKey)"
            :action="action"/>
</template>
<script setup>
import { useActions } from '@/composables/useActions'
import { useStore } from 'vuex'

const store = useStore()

const emitter = defineEmits(['actionExecuted'])

const props = defineProps({
    resourceName: {},
    viaResource: {},
    viaResourceId: {},
    viaRelationship: {},
    relationshipType: {},
    actions: { type: Array, default: [] },
    selectedResources: { type: [Array, String], default: () => [] },
    endpoint: { type: String, default: null },
});


const {
    errors,
    actionModalVisible,
    responseModalVisible,
    openConfirmationModal,
    closeConfirmationModal,
    closeResponseModal,
    handleActionClick,
    selectedAction,
    working,
    executeAction,
    actionResponseData,
} = useActions(props, emitter, store)

const runAction = () => executeAction(() => emitter('actionExecuted'))

const handleResponseModalConfirm = () => {
    closeResponseModal()
    emitter('actionExecuted')
}

const handleResponseModalClose = () => {
    closeResponseModal()
    emitter('actionExecuted')
}
</script>
