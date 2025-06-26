<script setup lang="ts">
import CustomerChart from '@/components/Charts/CustomerChart.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
];

const props = defineProps<{
  labels: string[];
  pagados: number[];
  noPagados: number[];
  montosPagados: number;
  labelsMontos: string[];
  valoresMontos: number[];
}>();

const chartData = {
  comprobantes: {
    labels: props.labels,
    series: [
      { name: 'Pagados', data: props.pagados },
      { name: 'Vencidos', data: props.noPagados },
    ],
  },
  montos: {
    labels: props.labelsMontos,
    values: props.valoresMontos,
  },
};
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <!-- Módulo 1: Comprobantes por mes -->
        <div
          class="relative aspect-auto overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
          <CustomerChart
            :columns-x="chartData.comprobantes.labels"
            :series="chartData.comprobantes.series"
            title="Comprobantes por mes en el año"
            subtitle="Pagados - Vencidos"
            chart-type="bar"
          />
        </div>

        <!-- Módulo 2: Placeholder -->
        <div class="relative aspect-auto overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-muted/40" />

        <!-- Módulo 3: Placeholder -->
        <div class="relative aspect-auto overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-muted/40" />
      </div>

      <!-- Módulo grande: Gráfico de Montos Pagados -->
<div class="relative h-[400px] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white p-6">
<CustomerChart
  :columns-x="chartData.montos.labels"
  :series="[
    { name: 'Montos Pagados', data: chartData.montos.values }
  ]"
  title="Montos Pagados"
  subtitle="Total de montos pagados por mes"
  chart-type="radar"
  :show-total="true"
/>
</div>
    </div>
  </AppLayout>
</template>