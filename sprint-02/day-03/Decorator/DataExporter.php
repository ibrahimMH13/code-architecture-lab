<?php



interface IDataExporter {
    public function export(array $data): string;
}

class JsonExporter implements IDataExporter {
    public function export(array $data): string {
        return json_encode($data);
    }
}

class DataExporterDecorator implements IDataExporter {
    public function __construct(protected IDataExporter $exporter) {}
    public function export(array $data): string {
        return $this->exporter->export($data);
    }
}

class SocialMediaAccountDecorator extends DataExporterDecorator {
    public function export(array $data): string {
        $data['SM']['X'] = "@XX";
        $data['SM']['FB'] = "@XX";
        $data['SM']['TIKTOK'] = "@XX";
        $data['SM']['YT'] = "@XX";
        return parent::export($data);
    }
}

class LogExportedDataDecorator extends DataExporterDecorator {
    public function export(array $data): string {
        $result = parent::export($data);
        // Now we log the **exported string**, not the array
        file_put_contents('./test.log', $result . "\n", FILE_APPEND);
        return $result;
    }
}

class CompressionDecorator extends DataExporterDecorator {
    public function export(array $data): string {
        $result = parent::export($data);  
        echo "gz\n";
        return gzencode($result);
    }
}

// Usage
$exporter = new JsonExporter();
$exporter = new SocialMediaAccountDecorator($exporter);
$exporter = new LogExportedDataDecorator($exporter); 
$exporter = new CompressionDecorator($exporter); 

$data = [
    "email" => "ibro@example.com",
    "age" => 33,
    "address" => "KL"
];

// The export chain
$output = $exporter->export($data);

// For demo: decompress and print, just to check the output!
echo gzdecode($output);
