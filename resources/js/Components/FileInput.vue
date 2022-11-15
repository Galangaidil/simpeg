<template>
    <input @change="$emit('previewFile', $event.target)" type="file" class="block w-full mt-1 text-sm text-slate-500
      file:mr-4 file:py-2 file:px-4
      file:rounded-full file:border-0
      file:text-sm file:font-semibold
      file:bg-indigo-50 file:text-indigo-500
      hover:file:bg-indigo-100
      focus:outline-none
    "/>
</template>
