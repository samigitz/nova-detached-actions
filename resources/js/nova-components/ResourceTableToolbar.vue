<template>
  <div
      class="flex flex-col md:flex-row md:items-center"
      :class="{
      'py-3 border-b border-gray-200 dark:border-gray-700':
        shouldShowCheckboxes ||
        shouldShowDeleteMenu ||
        softDeletes ||
        !viaResource ||
        hasFilters ||
        haveStandaloneActions,
    }"
  >
    <div class="flex items-center flex-1">
      <div class="md:ml-3">
        <SelectAllDropdown
            v-if="shouldShowCheckboxes"
            :all-matching-resource-count="allMatchingResourceCount"
            :current-page-count="currentPageCount"
            @toggle-select-all="toggleSelectAll"
            @toggle-select-all-matching="toggleSelectAllMatching"
            @deselect="$emit('deselect')"
        />
      </div>

      <!-- Toolbar Items -->
      <div class="h-9 ml-auto flex items-center pr-2 md:pr-3">
        <IndexActions :resourceName="resourceName"></IndexActions>
        <!-- Action Selector -->
        <div class="hidden md:flex px-2">
          <ActionSelector
              v-if="shouldShowActionSelector"
              :resource-name="resourceName"
              :via-resource="actionQueryString.viaResource"
              :via-resource-id="actionQueryString.viaResourceId"
              :via-relationship="actionQueryString.viaRelationship"
              :actions="availableActions"
              :pivot-actions="pivotActions"
              :pivot-name="pivotName"
              :endpoint="actionsEndpoint"
              :selected-resources="selectedResourcesForActionSelector"
              @actionExecuted="getResources"
          />
        </div>


        <!-- Resource Polling -->
        <Button
            @click="togglePolling"
            v-if="shouldShowPollingToggle"
            icon="clock"
            variant="link"
            :state="currentlyPolling ? 'default' : 'mellow'"
        />

        <!-- Lenses -->
        <LensSelector
            v-if="lenses?.length > 0"
            :resource-name="resourceName"
            :lenses="lenses"
        />

        <!-- Filters -->
        <FilterMenu
            v-if="filters.length > 0 || softDeletes || !viaResource"
            :active-filter-count="activeFilterCount"
            :filters-are-applied="filtersAreApplied"
            :filters="filters"
            :per-page-options="filterPerPageOptions"
            :per-page="perPage"
            :resource-name="resourceName"
            :soft-deletes="softDeletes"
            :trashed="trashed"
            :via-resource="viaResource"
            @clear-selected-filters="clearSelectedFilters(lens || null)"
            @filter-changed="filterChanged"
            @per-page-changed="updatePerPageChanged"
            @trashed-changed="trashedChanged"
        />

        <DeleteMenu
            class="flex"
            v-if="shouldShowDeleteMenu"
            dusk="delete-menu"
            :soft-deletes="softDeletes"
            :resources="resources"
            :selected-resources="selectedResources"
            :via-many-to-many="viaManyToMany"
            :all-matching-resource-count="allMatchingResourceCount"
            :all-matching-selected="selectAllMatchingChecked"
            :authorized-to-delete-selected-resources="
            authorizedToDeleteSelectedResources
          "
            :authorized-to-force-delete-selected-resources="
            authorizedToForceDeleteSelectedResources
          "
            :authorized-to-delete-any-resources="authorizedToDeleteAnyResources"
            :authorized-to-force-delete-any-resources="
            authorizedToForceDeleteAnyResources
          "
            :authorized-to-restore-selected-resources="
            authorizedToRestoreSelectedResources
          "
            :authorized-to-restore-any-resources="authorizedToRestoreAnyResources"
            @deleteSelected="deleteSelectedResources"
            @deleteAllMatching="deleteAllMatchingResources"
            @forceDeleteSelected="forceDeleteSelectedResources"
            @forceDeleteAllMatching="forceDeleteAllMatchingResources"
            @restoreSelected="restoreSelectedResources"
            @restoreAllMatching="restoreAllMatchingResources"
            @close="closeDeleteModal"
            :trashed-parameter="trashedParameter"
        />
      </div>
    </div>

    <!-- Mobile Action Selector -->
    <div
        v-if="shouldShowActionSelector"
        class="flex items-center md:hidden px-2 pt-3 mt-2 md:mt-0 border-t border-gray-200 dark:border-gray-700"
    >
      <ActionSelector
          width="full"
          :resource-name="resourceName"
          :via-resource="actionQueryString.viaResource"
          :via-resource-id="actionQueryString.viaResourceId"
          :via-relationship="actionQueryString.viaRelationship"
          :actions="availableActions"
          :pivot-actions="pivotActions"
          :pivot-name="pivotName"
          :endpoint="actionsEndpoint"
          :selected-resources="selectedResourcesForActionSelector"
          @actionExecuted="getResources"
      />
    </div>
  </div>
</template>

<script>
import ResourceTableToolbar from "@/components/ResourceTableToolbar";

export default {
  extends: ResourceTableToolbar,
};
</script>
