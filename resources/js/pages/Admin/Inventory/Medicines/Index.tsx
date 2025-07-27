import Header from '@/components/Admin/Header';
import { DataTableColumnHeader } from '@/components/DataTable/Columns';
import { DataTable } from '@/components/DataTable/Data-Table';
import { Skeleton } from '@/components/ui/skeleton';
import { Link } from '@inertiajs/react';
import { ColumnDef } from '@tanstack/react-table';
import axios from 'axios';
import { useEffect, useState } from 'react';
import { MdKeyboardDoubleArrowRight } from 'react-icons/md';

interface Product {
    name: string;
    brand: string;
    category_id: number;
    price: number;
    cost: number;
    stock: number;
    reorder_level: number;
    expiry_date: string;
    description: string;
    how_to_use: string;
    side_effects: string;
}

export type Medicine = {
    medicineName: string;
    medicineId: string;
    groupName: string;
    stockInQty: number;
};

const columns: ColumnDef<Medicine>[] = [
    {
        accessorKey: 'medicineName',
        header: ({ column }) => <DataTableColumnHeader column={column} title="Medicine Name" />,
    },
    {
        accessorKey: 'medicineId',
        header: ({ column }) => <DataTableColumnHeader column={column} title="Medicine ID" />,
    },
    {
        accessorKey: 'groupName',
        header: ({ column }) => <DataTableColumnHeader column={column} title="Group Name" />,
    },
    {
        accessorKey: 'stockInQty',
        header: ({ column }) => <DataTableColumnHeader column={column} title="Stock in Qty" />,
        cell: ({ row }) => {
            const qty = parseFloat(row.getValue('stockInQty'));
            const formatted = new Intl.NumberFormat('en-US').format(qty);
            return <div className="font-medium">{formatted}</div>;
        },
    },
    {
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => {
            const medicine = row.original;
            return (
                <Link className="flex items-center" href="#">
                    View Full Detail
                    <MdKeyboardDoubleArrowRight size="1.2em" />
                </Link>
            );
        },
    },
];

const Index = () => {
    const [products, setProducts] = useState<Medicine[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios.get('/api/products').then((res) => {
            setProducts(res.data);
            setLoading(false);
        });
    }, []);

    return (
        <>
            <Header
                header={'Medicine List'}
                subHeader="Manage your medicines effectively"
                actionLabel="Add New Item"
                onActionClick={() => console.log('Clicked')}
            />

            <div className="flex flex-1 flex-col overflow-auto px-6">
                {loading ? (
                    <div className="space-y-2">
                        {Array.from({ length: 6 }).map((_, i) => (
                            <div key={i} className="flex items-center">
                                <Skeleton className="h-4 w-[150px]" />
                                <Skeleton className="h-4 w-[100px]" />
                                <Skeleton className="h-4 w-[120px]" />
                                <Skeleton className="h-4 w-[80px]" />
                                <Skeleton className="h-4 w-[100px]" />
                            </div>
                        ))}
                    </div>
                ) : (
                    <DataTable columns={columns} data={products} />
                )}
            </div>
        </>
    );
};

export default Index;
