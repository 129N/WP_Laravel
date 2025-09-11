import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { router } from '@inertiajs/react';


import React from 'react';
import { View, Text, TouchableOpacity, ScrollView, StyleSheet } from 'react-native';
import { useNavigation } from '@react-navigation/native';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />

            <div className="p-6 text-xl font-semibold text-white-500">
            🚀 Hello! You are on the Dashboard Page.
            </div> 
            <div className="p-6 text-white-500 space-y-2">
        <h2 className="text-lg font-bold">System Tasks</h2>
        <p> Login system</p>
        <p> Admin: create map, set waypoints, view map</p>
        <p> Participants: register, join events</p>
        <p> Audience: view & filter participants</p>
      </div>
 

      <div className="p-6 space-x-4">
        <button
          className="p-2 bg-blue-500 text-white rounded"
           onClick={() => router.visit('/participant')}
        >Participant</button>

        <button
          className="p-2 bg-green-500 text-white rounded"
           onClick={() => router.visit('/admin')}
        >
          Event Holder Admin</button>


        <button
          className="p-2 bg-purple-500 text-white rounded"
          onClick={() => router.visit('/audience')}
        >
          Audience
        </button>
      </div> 
      
     

            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                        <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    </div>
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                        <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    </div>
                    <div className="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border">
                        <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                    </div>
                </div>
                <div className="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
                    <PlaceholderPattern className="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>
            </div>
        </AppLayout>
    );
}
