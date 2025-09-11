
import { type NavItem } from '@/types';
import { LayoutPanelTop, Settings,UsersRound,Video,Bike  } from 'lucide-react';
import { title } from 'process';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { Link } from '@inertiajs/react';

const Second_NavItems: NavItem[] = [
   {
    title: 'Test side bar',
    href: '/Test',
    icon: LayoutPanelTop,   
   },{
    title: 'Participant',
    href: '/participant',
    icon: Bike , 
   },
   {
    title: 'Administrator',
    href: '/admin',
    icon: UsersRound, 
   },{
    title: 'Audience',
    href: '/audience',
    icon: Video, 
   },{
    title: 'Settings',
    href: '/settings',
    icon: Settings, 
   }
];



export function AppSecondarySidebar(){
    return(
        <Sidebar collapsible="icon" variant="inset">


            <SidebarMenu>
            <SidebarMenuItem>

                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/profile" prefetch>
                                <span className="text-lg font-bold">User Panel</span>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>

            </SidebarMenu>

            <SidebarContent>
                {Second_NavItems.map((item) => (
                    <SidebarMenuItem key={item.title}>
                        <SidebarMenuButton asChild>
                            <Link href={item.href}>
                                {item.icon && <item.icon className="mr-2 h-5 w-5" />}
                                {item.title}
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                ))}
            </SidebarContent>



        </Sidebar>
    );
}