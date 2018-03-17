<?php

function createPanel(string $path): string
{
    if (isset($_GET["page"])) {
        if ($_GET["page"] == "new") {
            $panel = processAdding($path);
        } elseif ($_GET["page"] == "replace") {
            $panel = processReplacing($path, $_GET["replaceNumber"]);
        }
    } else {
        if (isset($_GET["remove"])) {
            removeFile($path, $_GET["remove"]);
        }
        $panel = drawEditingPanel($path);
    }
    return $panel;
}

function processReplacing(string $path,  $number): string
{
    if (isset($_POST["filePath"])) {
        replaceFile($path, $_POST["filePath"], $number);
    }
    $panel = drawReplacingPanel($path, $number);
    return $panel;
}

function replaceFile(string $path, string $newPath, int $number): void
{
    var_dump(rename(
        $path . basename(getFullFileNames($path)[$number]),
        $path . $newPath . basename(getFullFileNames($path)[$number])
    ));
}

function drawReplacingPanel(string $path, int $number): string
{
    $panel = "<form method='post'><table>";
    $panel .= "
            <tr>
                <th>Name</th>
            </tr>
            <tr>
                <td>" . basename(getFullFileNames($path)[$number]) . "</td>
            </tr>
            <tr>
                <td><input type='text' placeholder='path' name='filePath'></td>
            </tr>
            <tr>
                <td><input type='submit' value='replace'></td>
            </tr>
        ";
    $panel .= "</table></form>";
    $panel .= "<p><a href='fileSystem.php'>Back</a></p>";
    return $panel;
}

function processAdding(string $path): string
{
    if (isset($_POST["fileName"])) {
        createNew($path, $_POST["fileName"], $_POST["fileContent"], $_POST["fileType"]);
    }
    $panel = drawAddingPanel();
    return $panel;
}

function removeFile( string $path, int $number): void
{
    $fileNames = getFullFileNames($path);
    unlink($fileNames[$number]);
}

function createNew(string $path, string $fileName, $fileContents, $fileType): void
{
    $newFile = fopen($path . $fileName, "w");
    if ($fileType == "file") {
        if ($fileContents == null) {
            $fileContents = " ";
        }
        if (fwrite($newFile, $fileContents)) {
            echo "<script>location.href='fileSystem.php'</script>";
        } else {
            echo "<script>alert('Problems with file creation')</script>";
        }
    } else {
        if (mkdir($path . $fileName, 0775)) {
            echo "<script>location.href='fileSystem.php'</script>";
        }else {
            echo "<script>alert('Problems with directory creation')</script>";
        }
    }
}

function drawAddingPanel(): string
{
    $panel = "<form method='post'><table id='addingTable'>";
    $panel .= "
            <tr>
                <th>Name</th>
            </tr>
            <tr>
                <td><input type='text' placeholder='name' name='fileName'></td>
            </tr>
            <tr>
                <th>Content</th>
            </tr>
            <tr>
                <td><textarea placeholder='content' id='fileContent' name='fileContent'></textarea></td>
            </tr>
            <tr>
                <td><input type='submit' value='Create'></td>
            </tr>
            <tr>
                <td>
                    <label>File<input type='radio' name='fileType' value='file' checked></label>
                    <label>Directory<input type='radio' name='fileType' value='directory'></label>
                </td>
            </tr>
        ";
    $panel .= "</table></form>";
    $panel .= "<p><a href='fileSystem.php'>Back</a></p>";
    return $panel;
}

function drawEditingPanel(string $path): string
{
    $panel = "<p><a href='?page=new'>New</a></p>";
    $panel .= "<form><table border='1'>
    <tr>
        <th>Name</th>
        <th>functions</th>
    </tr>";
    $fileNames = getFullFileNames($path);
    foreach ($fileNames as $number => $fileName) {
        $panel .= "<tr>
                <td>" . basename($fileName) . "</td>
                <td>
                    <a id='$number' href='?remove=$number'>Remove</a>
                    <a id='$number' href='?page=replace&replaceNumber=$number'>Replace</a>
                </td>
            </tr>";
    }
    $panel .= "</table></form>";
    return $panel;
}

function getFullFileNames(string $path): array
{
    $fileNames = [];
    if (is_dir($path)) {
        if ($directory = opendir($path)) {
            while ($fileName = readdir($directory)) {
                if ($fileName != "." && $fileName != "..") {
                    $fileNames[] = $path . $fileName;
                }
            }
        }
    } else {
        die("Not correct path or it's not a directory.");
    }
    return $fileNames;
}