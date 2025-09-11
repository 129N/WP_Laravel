import AppLayout from "@/layouts/app-layout";
import { Head } from '@inertiajs/react';
import {Link} from '@inertiajs/react';

export default function Admin(){
    return (
        <AppLayout>
            <Head title="admin" />
            <div className="p-10 text-3xl font-bold text-blue-600">
             Administrator = Event Holder
            </div>

            <div className="p-4 bg-gray-600 text-white">

                <Link
                className="p-2 bg-red-500 text-white m-2 inline-block"
                href="/dashboard"
                >
                Back to Login
                </Link>

                <div className="flex flex-col gap-4 w-full max-w-md">
                <Link
                    className="p-3 bg-blue-500 text-white font-bold rounded hover:bg-blue-600"
                    href="/competition"
                >
                    Create Map
                </Link>

                <Link
                    className="p-3 bg-green-500 text-white font-bold rounded hover:bg-green-600"
                    href="/registration"
                >
                    View Map
                </Link>

                <Link
                    className="p-3 bg-purple-500 text-white font-bold rounded hover:bg-purple-600"
                    href="/history"
                >
                    Check the History
                </Link>
                </div>
                </div>

        </AppLayout>
    );
}