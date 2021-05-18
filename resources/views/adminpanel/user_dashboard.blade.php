@extends('adminpanel.layout.default')
@section('content')
    <div class="col-lg-12 col-md-12 p-4">
        <!-- start info box -->
        <div class="print-class d-flex justify-content-between align-items-center">

            <div class="d-flex" id="print-button-main">
{{--                <button class="btn btn-primary mr-2 print-report"><i class=" fa fa-print text-white" style="font-size: 20px;margin-right: 10px;cursor: pointer;" aria-hidden="true"></i>Print</button>--}}
{{--                <button class="btn btn-primary" data-toggle="modal" data-target="#save_report_modal"><i class=" fa fa-download text-white" style="font-size: 20px;margin-right: 10px;cursor: pointer;" aria-hidden="true"></i>Save Report</button>--}}
            </div>
        </div>

        <div class="row printableArea">
            <div class="col-md-6 pl-3 pt-2 m-auto" style="margin: auto;">
                <div class="card" >
                <form action="{{route('import-data-info-page')}}" method="get">
                    @csrf
                    <div class="card-header" style="background: white;">
                        <div class="card-header" style="background: white;">
                            <div class="row ">
                                <div class="col-md-12 px-3 pt-2">
                                    <div class="d-flex justify-content-between align-items-center mr-2">
                                        <h5>Sync Product</h5>
                                        {{--                                    <a href=""><button class="btn-primary">Customer Sync</button></a>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item p-3">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div style="margin-right: 3%;">
                                            <input checked required value="upload-file" type="radio" style="display: block !important;" name="choose_file" class="form-radio-input">
                                        </div>
                                        <div class="d-block">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img class="mr-2" style="margin-top: -12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAFAElEQVRYhe2Vz29UVRTHv+fc19IWw0zb8DPTefe9qaIxGGoFERAHXChiBF0AURMJMRITdaWJG+PCP0BXBmNMXLjRqIi/QoKKBI3RpCALA8b58e50SDpA2ykjTDvz3j0unDEN7dBCTYwJ3+XLPefzPeeedy5wU/+x6N9IMjg42FYul1fXarUOIqoSkY2iKCwWizkA0bVi1ULhrusO1Gq17lqtViUin5l7lVKxtra2jq6urpFLly5d08CCOpBMJjc5jjMM4DYAhVwu9wcAAYC+vr5VSql1zHwml8tlMUcnrlu+76/zfT+ZTCYfBcAtjpHrus+mUql+tOh2q8BryvO8+wGUwjC8q1AofAnAtjgqnue9b629r7+/f/FsB657BrTWG6y1I0S0xhjzFQCkUqn+eDy+Px6P39vd3d1eLpcLzfNBENh4PN7DzD1jY2PFBRnQWm8AMEJE64MgOASAtNavWGuXicgiIlpERKvi8XiiXC7/1oyLx+OTRNTb2dk5WqlU6tNzzvsKksnkJhEpAVgbBMFHDUOvicgoET1mrT2slPpYRAYArNRad/xTpVJWRDQzy9V552XAdd2N7e3tBsDtQRAcBgDP814WkSKAXSLy6vDwcDabzWYAOAAmmTnZjI+iyAdQWr58eXh1bmcuuNZ6AzMXwzDsN8YcaXx7CYAhor1E9EI+nzcNo48AyBBRgplNMwcR3VqpVI7mcrn61fmv2QHXde9WSp2LoujOIAiOAxCt9QEAZRF5JgzDF5twz/O2ENEaABVr7aeZTGaqYXattfZib2/vDPicBph5tFar6WmVP09El0VkMAzD54rF4rmG0a0islcpVQbwnTHmJADled5uZh5g5tyKFSsmZmPMdxOS53lviMgoMy9i5rczmcylBnwHgH1ENEREh/L5/O8A4Pv+DhHptNYOGWOGAcy4/zk7MA3+lLU2Z61d2t7e/m4TrrV+mIgOENG3InK8AVepVGpbFEUxpdRxY4xpBQfmMYSpVGongD9FZP3U1NSbhUJhFACSyeSDAPaIyHEiOmOM+WlwcLBtfHz8oTAMYwDylUrlClpvybkNuK77eBRFVQADzHxwZGTkQuP7VgD7ROQsM5/I5/O/AOCxsbGtzNzDzMLMmVKpdHmuAlsa0FrvI6IxEVlfrVYPlkql8wDg+/49URRtV0qdI6Ij2Wx2CIByXfcBIloaRdFUGIY/FIvF83PBgRYzoLXeSURXrLWbieidafDNURStZ+a6tbYJZ9/3dxFRn7V2meM4Pzb/jvloxluQSCQ6lVLbiSgxOTn5VrMSz/O2iMg2ADFr7TFjzLF0Ou0w825rbbeIdCilPstms8PzhQOzXIFS6g4AUq/XT0278wER2Q6gTEQ/G2O+T6fTTi6X28/Mi0WE29raPsxkMjNeu+s2wMwJEelqrtJEItEJYCOAqrX2m0KhMJROpx1jzJNEdAsAh4g+vxE4MMsMWGsvElEVwEoAKBaLU8xcsdZ+Mg2+V0SIiJaIyBdBEJy9ETgwywzEYrElzNxHRKt7enpOjo+PT5bL5dMTExMX0um0UygU9lhrY8zsAfjaGPPrjcKB2Vcxaa1fF5ECEa1xHOdwvV6fUEo5IrIWgFhrNREdbTxQC9Ksb4Hv+zFr7UFmPhFFERFRu4hMENGoiGxm5g/y+fzphcJbGmhIaa2fBvAE/l6nZQCnqtXqe/PZcDf1v9FfrZdlHv/VwoQAAAAASUVORK5CYII=" title="file">
                                                <p style="font-size: 22px;">Upload a file</p>
                                            </div>
                                            <div style="color: grey;margin-top: -5px;">
                                                File is at your computer - can upload the file from my computer.
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div style="margin-right: 3%;">
                                            <input required type="radio" value="import-via-url" style="display: block !important;" name="choose_file" class="form-radio-input">
                                        </div>
                                        <div class="d-block">
                                            <div class="d-flex justify-content-start align-items-center">

                                                <img class="mr-2" style="margin-top: -12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAADGklEQVRYhe2Uv2tkVRTHv99z35tfa9a4MzEhDMObJQbZARGExUpinULU0n/AxkKs7CwsrGwsrGQ7W2s3Iim0kiAoAxo3P14yJoaY4GZm5znv3XuOzewQMTsRLJ1Pde+5nHs+nMO9wIwZM2b833FXBVut1jNLS0u3KpVKqd/vZ/+xhkw75OXNyspK08zWvfc3SfZJehGR0WikzrkSyTPnXF4URd85RwAIIWRxHBvJuCgKieM4eO9JMphZbmYHjUbj4WAwcN776s7OzikA+4dAq9W67Zx7G8Chmb0I4MLMHMmumT1FMgDIxusIwB0z+6hcLs/lef6JmX0DQEWkZmY/AKgCIMm+mS0AiM1so1ar7S8uLp5ubm76iUCz2azGcfwugAsAKIris16v98TWJ0nysqo2SN4FUCW5o6o/HhwcfPuknE6nUxoMBu94778qlUrP7u3tbUzmU6lU7ppZRnJuOBzem1YcAMzsLZIJgE8BfE7yURRF65gy7263m6dp+nEcx68DmE+SZGki4L2nmRVmdnZycvJoWnEAjuQNAC+kaXqcpun3tVptw3t/nCTJ6jW5ZmYDACMzuz0RAPAngJKZXfkqLtPpdBzJPZLZ2tpaBADD4fBp51wZwB/X5ZNcCCEMRaR+WWBfRByAxSRJKtMu6Ha7uaoeAThO0/ROs9mshhAWRGRUr9fP/oWAF5HnVPXBRCBJkt/H9vsisn7dJVEU3Sf5BYDX4jh+M4qi+RDCd1tbW8W0vHa7/UoURV8CeDVN05+AS88wSZJ5M3tPRH5W1bJz7jdVHZiZE5EBSQ0hqIh4Mzvw3t+I4zgCsGhmb5jZfQBGMhORAMBCCME5d5bn+WmWZbfq9fpcURQfknx/d3f3l78JAMDq6mqjKIoPVFVJnpN8AOB5AA/HbTcR8araEBEfQqiQ9CTPx+1VVS1I3jSzi/GcT0gOVfUlVT0ys68PDw+PJiO5qlXLy8u1arW6bGbzIQQdh7Moilye5+ckM1Wt9Xq9XwG4drvdJLmgqgPnnFfVGoDRY6FSqTTY3t4+w6UfcMaMGTNmPOYvnc2TGQt/XJoAAAAASUVORK5CYII=" title="url">
                                                <p style="font-size: 22px;">Import via URL</p>
                                            </div>
                                            <div style="color: grey;margin-top: -5px;">
                                                File is at http server - have a url to access the file.
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div style="margin-right: 3%;">
                                            <input required type="radio" value="import-via-ftp" style="display: block !important;" name="choose_file" class="form-radio-input">
                                        </div>
                                        <div class="d-block">
                                            <div class="d-flex justify-content-start align-items-center">
                                                <img class="mr-2" style="margin-top: -12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAAAl9JREFUWIXtlr9rFFEQx2feXpIL6sY9vRAk92beJSBiIy4pLAWVCBZiRAJW2vkPaKMpUsdC/BMEwV47bRUMB6JwaOFdcjmv0cWc+DOb98bGiITb3cvlYqH5VrvvOzPvw7A77wHs6n+Xt5VYIroWBEGwurr6tl8AqttAZr7sed5DRBzRWgf9AuhK5XJ5lIimN96NMTP9qt1VB5xz08z8+HeSUs+Z+VK/IFJFRCeJ6NjmdWPMxYmJidJ266d2gJkPA8CJ5eXlF5u9OI4fWWvP7iiAiFzN5/N3O3nNZvMbIj5j5jPbhegoIrpgjJnKitNaz2itw173SeyAiPwQkfNa63NJMcaYKUR0ACC9AmBWADPPLS0tzXfySqXSUc/zDgLAmFJq//r6+mfP84ZFZE1EDoiI12g0FtLq57IARGRvYnIuVwCA0Xq9/qCTr7XOnBdZcwAR8UuSaa2NnHMDKcmZIzsVIAzDnIh8SvKdc+3U4kq5bQFUKpUYEaMk3/f99wAwluRba/dlAWR+AwAwxMw3nHMflFJ7RKSplDpkrX1drVafaK3fJCUi4rsu6vcmrfVxIrqSMStUGIYDkPK3dX0cb1axWHyFiMV6vb6YEuaiKJotl8uJZ0bPAJVKJQaAj8aYU0kx4+PjBQBYq9VqjV73yRQRzRNRvoOFzHwrK7/nDmwojuM7iHi9A9istfb+jgO0Wq1IRF4aY07/sfkRABhZWVnp290xU8x8e3Jy0v/1PAddnDMAW7sVp8r3/UXn3M1CoUCDg4P3oij6+lcB2u329yAIhkVkqFarPe1X3V39+/oJz+O+KvRukE0AAAAASUVORK5CYII=" title="ftp">
                                                <p style="font-size: 22px;">Import via FTP</p>
                                            </div>
                                            <div style="color: grey;margin-top: -5px;">
                                                File is at ftp server - have a ftp credentials to access the file.
                                            </div>
                                        </div>
                                    </div>
                                </li>

{{--                                <li class="list-group-item">--}}
{{--                                    <div class="d-flex justify-content-start align-items-center">--}}
{{--                                        <div style="margin-right: 3%;">--}}
{{--                                            <input required value="import-via-api" type="radio" style="display: block !important;" name="choose_file" class="form-radio-input">--}}
{{--                                        </div>--}}
{{--                                        <div class="d-block">--}}
{{--                                            <div class="d-flex justify-content-start align-items-center">--}}
{{--                                                <img class="mr-2" style="margin-top: -12px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAFAElEQVRYhe2Vz29UVRTHv+fc19IWw0zb8DPTefe9qaIxGGoFERAHXChiBF0AURMJMRITdaWJG+PCP0BXBmNMXLjRqIi/QoKKBI3RpCALA8b58e50SDpA2ykjTDvz3j0unDEN7dBCTYwJ3+XLPefzPeeedy5wU/+x6N9IMjg42FYul1fXarUOIqoSkY2iKCwWizkA0bVi1ULhrusO1Gq17lqtViUin5l7lVKxtra2jq6urpFLly5d08CCOpBMJjc5jjMM4DYAhVwu9wcAAYC+vr5VSql1zHwml8tlMUcnrlu+76/zfT+ZTCYfBcAtjpHrus+mUql+tOh2q8BryvO8+wGUwjC8q1AofAnAtjgqnue9b629r7+/f/FsB657BrTWG6y1I0S0xhjzFQCkUqn+eDy+Px6P39vd3d1eLpcLzfNBENh4PN7DzD1jY2PFBRnQWm8AMEJE64MgOASAtNavWGuXicgiIlpERKvi8XiiXC7/1oyLx+OTRNTb2dk5WqlU6tNzzvsKksnkJhEpAVgbBMFHDUOvicgoET1mrT2slPpYRAYArNRad/xTpVJWRDQzy9V552XAdd2N7e3tBsDtQRAcBgDP814WkSKAXSLy6vDwcDabzWYAOAAmmTnZjI+iyAdQWr58eXh1bmcuuNZ6AzMXwzDsN8YcaXx7CYAhor1E9EI+nzcNo48AyBBRgplNMwcR3VqpVI7mcrn61fmv2QHXde9WSp2LoujOIAiOAxCt9QEAZRF5JgzDF5twz/O2ENEaABVr7aeZTGaqYXattfZib2/vDPicBph5tFar6WmVP09El0VkMAzD54rF4rmG0a0islcpVQbwnTHmJADled5uZh5g5tyKFSsmZmPMdxOS53lviMgoMy9i5rczmcylBnwHgH1ENEREh/L5/O8A4Pv+DhHptNYOGWOGAcy4/zk7MA3+lLU2Z61d2t7e/m4TrrV+mIgOENG3InK8AVepVGpbFEUxpdRxY4xpBQfmMYSpVGongD9FZP3U1NSbhUJhFACSyeSDAPaIyHEiOmOM+WlwcLBtfHz8oTAMYwDylUrlClpvybkNuK77eBRFVQADzHxwZGTkQuP7VgD7ROQsM5/I5/O/AOCxsbGtzNzDzMLMmVKpdHmuAlsa0FrvI6IxEVlfrVYPlkql8wDg+/49URRtV0qdI6Ij2Wx2CIByXfcBIloaRdFUGIY/FIvF83PBgRYzoLXeSURXrLWbieidafDNURStZ+a6tbYJZ9/3dxFRn7V2meM4Pzb/jvloxluQSCQ6lVLbiSgxOTn5VrMSz/O2iMg2ADFr7TFjzLF0Ou0w825rbbeIdCilPstms8PzhQOzXIFS6g4AUq/XT0278wER2Q6gTEQ/G2O+T6fTTi6X28/Mi0WE29raPsxkMjNeu+s2wMwJEelqrtJEItEJYCOAqrX2m0KhMJROpx1jzJNEdAsAh4g+vxE4MMsMWGsvElEVwEoAKBaLU8xcsdZ+Mg2+V0SIiJaIyBdBEJy9ETgwywzEYrElzNxHRKt7enpOjo+PT5bL5dMTExMX0um0UygU9lhrY8zsAfjaGPPrjcKB2Vcxaa1fF5ECEa1xHOdwvV6fUEo5IrIWgFhrNREdbTxQC9Ksb4Hv+zFr7UFmPhFFERFRu4hMENGoiGxm5g/y+fzphcJbGmhIaa2fBvAE/l6nZQCnqtXqe/PZcDf1v9FfrZdlHv/VwoQAAAAASUVORK5CYII=" title="file">--}}
{{--                                                <p style="font-size: 22px;">Import via API</p>--}}
{{--                                            </div>--}}
{{--                                            <div style="color: grey;margin-top: -5px;">--}}
{{--                                                File is at your computer - can upload the file from my computer.--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
                            </ul>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="d-flex justify-content-end">
                            <a href="{{route('user-dashboard')}}"  class="btn btn-white mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-lg">Next</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection
@section('js_after')

    <script>

        $(document).ready(function() {

        });

    </script>
@endsection
