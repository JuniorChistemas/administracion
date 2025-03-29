<template>
    <Dialog :open="modal" @update:open="clouseModal">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Editando el descuento</DialogTitle>
                <DialogDescription>Los datos están validados, llenar con precaución.</DialogDescription>
            </DialogHeader>
            <form @submit="onSubmit" class="flex flex-col gap-4 py-4">
                <FormField v-slot="{ componentField }" name="description">
                    <FormItem>
                        <FormLabel>Descripción</FormLabel>
                        <FormControl>
                            <Input id="description" type="text" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="percentage">
                    <FormItem>
                        <FormLabel>Porcentaje</FormLabel>
                        <FormControl>
                            <Input id="percentage" type="number" step="0.01" v-bind="componentField" />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <FormField v-slot="{ componentField }" name="state">
                    <FormItem>
                        <FormLabel>Estado</FormLabel>
                        <FormControl>
                            <Select v-bind="componentField">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecciona el estado" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Estado</SelectLabel>
                                        <SelectItem value="activo">Activo</SelectItem>
                                        <SelectItem value="inactivo">Inactivo</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>
                <DialogFooter>
                    <Button type="submit">Guardar cambios</Button>
                    <Button type="button" variant="outline" @click="clouseModal">Cancelar</Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { watch } from 'vue';
import * as z from 'zod';

import { DiscountResource, DiscountUpdateRequest } from '@/pages/panel/discount/interface/Discount';

const props = defineProps<{ modal: boolean; discountData: DiscountResource }>();
const emit = defineEmits<{
    (e: 'emit-close', open: boolean): void;
    (e: 'update-discount', discount: DiscountUpdateRequest, id_discount: number): void;
}>();

const clouseModal = () => emit('emit-close', false);

// Schema de validación
const formSchema = toTypedSchema(
    z.object({
        description: z.string().min(3, 'La descripción es requerida').max(255, 'La descripción no puede tener más de 255 caracteres'),
        percentage: z.number().min(0, 'El porcentaje no puede ser negativo').max(100, 'El porcentaje no puede ser mayor a 100'),
        state: z.enum(['activo', 'inactivo']),
    }),
);

// Inicialización del formulario
const { handleSubmit, setValues } = useForm({
    validationSchema: formSchema,
    initialValues: {
        description: props.discountData.description,
        percentage: props.discountData.percentage,
        state: props.discountData.state ? 'activo' : 'inactivo',
    },
});
watch(
    () => props.discountData,
    (newData) => {
        if (newData) {
            setValues({
                description: newData.description,
                percentage: newData.percentage,
                state: newData.state ? 'activo' : 'inactivo',
            });
        }
    },
    { deep: true, immediate: true },
);

const onSubmit = handleSubmit((values) => {
    console.log('Formulario enviado con:', values);
    emit('update-discount', values, props.discountData.id);
    clouseModal();
});
</script>
<style scoped lang="css"></style>