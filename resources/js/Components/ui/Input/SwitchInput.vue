<script>

export default {
    name: 'SwitchInput',
    props: {
        modelValue: {
            type: Boolean,
            required: true,
            default: false,
        },
    },
    emits: ["update:modelValue"],
};
</script>

<template>
    <label class="ms-3 inline-flex cursor-pointer items-center">
        <input
            type="checkbox"
            class="peer sr-only"
            :checked="modelValue"
            @change="$emit('update:modelValue', $event.target.checked)"
        />
        <span
            class="peer relative h-5 w-9 rounded-full bg-red-300 peer-checked:bg-lime-300 after:absolute after:start-[2px] after:top-0.5 after:h-4 after:w-4 after:rounded-full after:border after:border-gray-400 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full"
        ></span>
    </label>
</template>
