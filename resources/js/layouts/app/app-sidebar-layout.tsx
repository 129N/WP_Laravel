import { AppContent } from '@/components/app-content';
import { AppShell } from '@/components/app-shell';
import { AppSidebar } from '@/components/app-sidebar';
import { AppSidebarHeader } from '@/components/app-sidebar-header';
import { AppSecondarySidebar } from '@/components/app-sidebar_second';

import { type PropsWithChildren } from 'react';
import { type BreadcrumbItem } from '@/types';

interface AppSidebarLayoutProps extends PropsWithChildren {
    breadcrumbs?: BreadcrumbItem[];
}

export default function AppSidebarLayout({ children }: AppSidebarLayoutProps) {
    return (
        <AppShell variant="sidebar">
            <AppSidebar />
            <AppSecondarySidebar />
            <AppContent variant="sidebar">
                <AppSidebarHeader />
                {children}
            </AppContent>
        </AppShell>
    );
}
